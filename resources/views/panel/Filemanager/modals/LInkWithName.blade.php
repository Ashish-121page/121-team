<!-- Modal -->
<div class="modal fade" id="linkwithnameModal" tabindex="-1" aria-labelledby="linkwithnameLabel" aria-hidden="true" style="overflow: auto;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-title d-flex justify-content-between">
                <div class="h5 m-2">Link With Name</div>
                <button type="button" class="btn btn-outline-primary m-2" data-bs-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <div class="modal-body">
                
                <form action="{{ route('panel.filemanager.link.saperator') }}" method="POST" id="delimetersaprationform">
                    @csrf
                    <input type="hidden" name="filepaths" id="filepathsinp">
                    <input type="hidden" name="filename" id="fileNameinp">

                    <div class="mb-3">
                        <label for="" class="form-label">2. SET THE CRITERIA TO LINK ASSETS TO PRODUCTS</label>
                        <br>
                        <small id="helpId" class="text-muted">Assets can be linked to products by matching part Of their name with a product attribute you can choose below </small>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="" class="form-label">ASSET NAME DELIMITER</label>
                                    <select class="form-control form-select-lg" name="delimiter" id="delimiter">
                                        <option selected></option>
                                        <option value="dash">(-) Dash</option>
                                        <option value="underscore">(_) Underscore</option>
                                        <option value="dot">(.) Dot</option>
                                        <option value="hashtag">(#) HashTag</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">    
                                <div class="form-group">
                                    <label for="alignment" class="form-label">TABLE ALIGNMENT</label>
                                    <select class="form-control form-select-lg" name="alignment" id="alignment">
                                        <option value="0">LEFT</option>
                                        <option value="1">RIGHT</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>  
                    </div>


                    <button type="submit" id="usdfjsd" class="btn btn-outline-primary mx-1">Submit</button>
                    <button type="button" id="fjxigusd" class="btn btn-outline-primary mx-1">Check Record</button>

                </form>


                <div class="row my-2">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    
                                    <tr>
                                        <th scope="col">Sno.</th>
<<<<<<< HEAD
                                        <th scope="col" id="usdhgn">One</th>
                                        <th scope="col" id="sdhfjn">Two</th> 
=======
                                        <th scope="col" id="usdhgn">Modal Code</th>
                                        <th scope="col" id="sdhfjn">Filename</th> 
>>>>>>> main
                                    </tr>
                                    
                                </thead>
                                <tbody id="yetsidh">
                                    
<<<<<<< HEAD
                                    <tr>
                                        <td>1</td>    
                                        <td>One</td>    
                                        <td>Two</td>    
                                    </tr>                                                                            
                                    
=======
>>>>>>> main
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>