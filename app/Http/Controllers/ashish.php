
            if($items[$accessCodeIndex] && $$items[$accessCodeIndex] != null){
                $chk_code = AccessCode::whereCode($items[$accessCodeIndex])->first();
                if(!$chk_code){
                return redirect()->back()->with('error','This access code is invalid!');
                }
    
                $chk_redeem = AccessCode::whereCode($items[$accessCodeIndex])->where('redeemed_user_id','!=',null)->first();
    
                //  Check already redeemed
                if($chk_redeem){
                return redirect()->back()->with('error','This access code is already redeemed!');
                }
            }

            //  store user information
            $user = User::create([
                'name'     => $items[$slugnameIndex],
                'email'    => $items[$emailIndex],
                'phone'    => $items[$phoneIndex],
                'gender'    => $items[$genderIndex],
                'password' => Hash::make($items[$passwordIndex]),
            ]);
            


            $user->update([
                'industry_id' => ["$industry"]
            ]);

            $permission_user = ["mycustomer"=> $items[$myCustomer_permissionIndex] ?? 'no',"Filemanager" => $items[$fileManager_permissionIndex] ?? 'no' ,"addandedit"=> $items[$AddandEdit_permissionIndex] ?? 'no' ,"pricegroup" => $items[$priceGroup_permissionIndex] ?? 'no' , "bulkupload"=> $items[$bulkUploads_permissionIndex] ?? 'no', "mysupplier"=> $items[$mySupplier_permissionIndex] ?? 'no', "manage_categories" => $items[$categoryGroup_permissionIndex] ?? 'no', "manangebrands" => $items[$Brand_permissionIndex]  ?? 'no'];

            $user->account_permission;
            $user->save();


            // assign new role to the user
            $user->syncRoles($userrole);

            if($request->role == 3){
                $contact_info = [
                    'phone' => $items[$phoneIndex],
                    'email' => $items[$emailIndex],
                    'whatsapp' => $items[$phoneIndex],
                ];
                $testimonial = [
                    'title' => 'Testimonials',
                    'description' => 'Our testimonial showing here',
                ];
                $products = [
                    'title' => 'Products Catalogue',
                    'description' => 'Explore our product',
                    'label' => 'Visit Shop',
                ];
                $about = [
                    'title' => 'About',
                    'content' => 'Bit about me',
                ];
                $story = [
                    'title' => 'About',
                ];
                $features = [
                    'title' => 'Reason to choose us',
                ];
                $team = [
                    'title' => 'Our Team',
                ];


                if($request->site_name){
                    $shop_name =  $items[$slugnameIndex];
                }else{
                    $shop_name =  $items[$nameofEntityIndex]."'s Shop";
                }
            

                // return $user->id;
                $user_shop = UserShop::create([
                    'user_id' => $user->id,
                    'name'=> $shop_name,
                    // 'slug'=> slugify($shop_name), // TODO Add slugify function
                    'slug'=> $items[$slugnameIndex], // TODO Add slugify function
                    'description'    => $items[$businessDescriptionIndex],
                    'logo' => null,
                    'contact_no' => $user->phone,
                    'status' => 0, // Active
                    'contact_info' => json_encode($contact_info),
                    'products' => json_encode($products),
                    'about' => json_encode($about),
                    'story' => json_encode($story),
                    'features' => json_encode($features),
                    'team' => json_encode($team),
                    'email' => $user->email,    
                ]);


                // Create Price Groups for User
                syncSystemPriceGroups($user->id);

                 // Code Has
                 if ($request->access_code != null && $chk_code) {

                    // Update Access Code 
                    $chk_code->update([
                        'redeemed_user_id' => $user->id,  
                        'redeemed_at' => now()
                    ]);

                    $user->update([
                        'is_supplier' => 1,
                    ]);

                    // Assign Trial Package
                    $package = Package::whereId(1)->first();
                    
                    if($package){
                        if($package->duration == null){
                                $duration = 30;
                        }else{
                            $duration = $package->duration;
                        }
                        $package_child = new UserPackage();
                        $package_child->user_id = $user->id;
                        $package_child->package_id = $package->id;
                        $package_child->order_id = 0; // For Trial Order
                        $package_child->from = now();
                        $package_child->to = now()->addDays($duration);
                        $package_child->limit = $package->limit;
                        $package_child->save();
                    }
                    
                }else{
                    $user->update([
                        'is_supplier' => $sellerpanel,
                    ]);
                }

                
                // Update Social Media Links

                $fb_link = $items[$fb_linkIndex];
                $in_link = $items[$linkedinIndex];
                $tw_link = $items[$twitterLinkIndex];
                $yt_link = $items[$youtubeLinkIndex];
                $insta_link = $items[$instagramLInkIndex];
                $pint_link = $items[$pinterestLinkIndex];
                $social_link = json_encode(array('fb_link' => $fb_link,'in_link' => $in_link ,'tw_link' => $tw_link , 'yt_link' => $yt_link,'insta_link' => $insta_link,'pint_link' => $pint_link));

                
                $UserShop = UserShop::find($user_shop->id);
                $UserShop->embedded_code = urlencode($items[$embeddedMapIndex]);
                $UserShop->social_links = $social_link;
                $UserShop->save();




                


               if ($items[$additionalPhoneIndex] != "") {
                    $userRecord = User::where('id',$user->id)->first();
                    // additonal Numbers
                    foreach(explode(',',$items[$additionalPhoneIndex]) as $number){
                        $user = User::where('id','!=',$user->id)->where('phone',$number)->first();
                        if(strlen($number) != 10){
                            return back()->with('error',$number.' Invalid Number Please Enter Valid Number!');
                        }
                        if(!$user){
                            $user = User::where('id','!=',$user->id)
                            ->whereJsonContains('additional_numbers',$number)
                            ->first();
                        }
                        if($user){
                            return back()->with('error',$number.' Number Already exists!');
                        }
                        if($userRecord->additional_numbers == null){
                            $phones[] = $number;
                            $userRecord->additional_numbers = json_encode($phones);
                        }else{
                            $phones = json_decode($userRecord->additional_numbers, true);
                            $phones[] = $number;
                            $userRecord->additional_numbers = json_encode($phones);
                        }
                        $userRecord->save();
                    }
               }






                
            }


            if ($user) {
                return redirect('panel/users/index')->with('success', 'New user created!');
            } else {
                return redirect('panel/users/index')->with('error', 'Failed to create new user! Try again.');
            }
