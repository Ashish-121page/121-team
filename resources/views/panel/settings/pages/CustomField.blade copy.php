@php
    $record = App\Models\Media::where('type_id', auth()->id())
        ->where('type', 'OfferBanner')
        ->get();
@endphp

<div class="card-body">
    <form action="{{ route('panel.settings.custom.fields') }}" method="post">
        <div class="row">
            <div class="col-12 col-md-4">

                <div class="mb-3">
                    <div class="h6"><b>Add Details</b></div>
                    <span>Fill the basic details of the new attribute</span>
                </div>

                <div class="mb-3">
                    <label for="attr_name" class="form-label">Name <span class="text-danger">*</span> </label>
                    <input type="text" name="attr_name" id="attr_name" class="form-control"
                        placeholder="Enter Attribute Name" required autofocus="true" />
                </div>

                <div class="mb-3">
                    <label for="attr_section" class="form-label">Section <span class="text-danger">*</span> </label>
                    <select name="attr_section" class="select2 form-control" id="attr_section" name="attr_section"
                        required>
                        <option value="1">Product Info > Essentials</option>
                        <option value="2">Product Info > Sale Price</option>
                        <option value="3">Product Info > Property</option>
                        <option value="4">Internal - Reference</option>
                        <option value="5">Internal - Production</option>
                    </select>
                </div>

                

                <div class="mb-3">
                    <label>Select Data Type</label>
                    <div style="display: flex;flex-wrap: wrap;">

                        <div class="cust_input">
                            <input class="form-check-input" type="radio" value="text" id="data_type"
                                name="data_type" />
                            <label class="form-check-label border" for="data_type">
                                <svg width="25" height="25" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M2.25 7A.75.75 0 0 1 3 6.25h10a.75.75 0 0 1 0 1.5H3A.75.75 0 0 1 2.25 7Zm14.25-.75a.75.75 0 0 1 .684.442l4.5 10a.75.75 0 1 1-1.368.616l-1.437-3.194H14.12l-1.437 3.194a.75.75 0 1 1-1.368-.616l4.5-10a.75.75 0 0 1 .684-.442Zm-1.704 6.364h3.408L16.5 8.828l-1.704 3.786ZM2.25 12a.75.75 0 0 1 .75-.75h7a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1-.75-.75Zm0 5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1-.75-.75Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Text</span>
                            </label>
                        </div>

                        <div class="cust_input">
                            <input class="form-check-input" type="radio" value="long_text" id="data_type2_long_text"
                                name="data_type" />
                            <label class="form-check-label border" for="data_type2_long_text">
                                <svg width="25" height="25" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20.439 4.062h-9a.5.5 0 1 1 0-1h9a.5.5 0 0 1 0 1Zm0 5.624h-9a.5.5 0 0 1 0-1h9a.5.5 0 0 1 0 1Zm0 5.624h-9a.5.5 0 0 1 0-1h9a.5.5 0 0 1 0 1Zm0 5.624h-9a.5.5 0 0 1 0-1h9a.5.5 0 0 1 0 1ZM3.208 18.8a.5.5 0 0 1 .71-.71l1.14 1.14V4.775l-1.14 1.14a.513.513 0 0 1-.71 0a.5.5 0 0 1 0-.71l2-2a.494.494 0 0 1 .34-.14a.549.549 0 0 1 .37.14l2 2a.524.524 0 0 1 0 .71a.5.5 0 0 1-.71 0l-1.15-1.15v14.47l1.15-1.15a.5.5 0 1 1 .71.71l-2 2a.513.513 0 0 1-.71 0Z" />
                                </svg>
                                <span>Long Text</span>
                            </label>
                        </div>

                        <div class="cust_input">
                            <input class="form-check-input" type="radio" value="date" id="data_type1_date"
                                name="data_type" />
                            <label class="form-check-label border" for="data_type1_date">
                                <svg width="25" height="25" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.673 0a.7.7 0 0 1 .7.7v1.309h7.517v-1.3a.7.7 0 0 1 1.4 0v1.3H18a2 2 0 0 1 2 1.999v13.993A2 2 0 0 1 18 20H2a2 2 0 0 1-2-1.999V4.008a2 2 0 0 1 2-1.999h2.973V.699a.7.7 0 0 1 .7-.699ZM1.4 7.742v10.259a.6.6 0 0 0 .6.6h16a.6.6 0 0 0 .6-.6V7.756L1.4 7.742Zm5.267 6.877v1.666H5v-1.666h1.667Zm4.166 0v1.666H9.167v-1.666h1.666Zm4.167 0v1.666h-1.667v-1.666H15Zm-8.333-3.977v1.666H5v-1.666h1.667Zm4.166 0v1.666H9.167v-1.666h1.666Zm4.167 0v1.666h-1.667v-1.666H15ZM4.973 3.408H2a.6.6 0 0 0-.6.6v2.335l17.2.014V4.008a.6.6 0 0 0-.6-.6h-2.71v.929a.7.7 0 0 1-1.4 0v-.929H6.373v.92a.7.7 0 0 1-1.4 0v-.92Z" />
                                </svg>
                                <span>Date</span>
                            </label>
                        </div>

                        <div class="cust_input">
                            <input class="form-check-input" type="radio" value="select" id="data_type1_single_select"
                                name="data_type" />
                            <label class="form-check-label border" for="data_type1_single_select">
                                <svg width="25" height="25" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m7.854 10.854l3.792 3.792a.5.5 0 0 0 .708 0l3.793-3.792a.5.5 0 0 0-.354-.854H8.207a.5.5 0 0 0-.353.854Z" />
                                    <path
                                        d="M2 3.75C2 2.784 2.784 2 3.75 2h16.5c.966 0 1.75.784 1.75 1.75v16.5A1.75 1.75 0 0 1 20.25 22H3.75A1.75 1.75 0 0 1 2 20.25Zm1.75-.25a.25.25 0 0 0-.25.25v16.5c0 .138.112.25.25.25h16.5a.25.25 0 0 0 .25-.25V3.75a.25.25 0 0 0-.25-.25Z" />
                                </svg>
                                <span>Single Select</span>
                            </label>
                        </div>

                        <div class="cust_input">
                            <input class="form-check-input" type="radio" value="price" id="data_type1_price"
                                name="data_type" />
                            <label class="form-check-label border" for="data_type1_price">
                                <svg width="25" height="25" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3 19V5h18v14H3Zm1-1h16V6H4v12Zm0 0V6v12Zm4.5-1.5h1v-1h1.23q.328 0 .549-.221q.221-.221.221-.548v-2.462q0-.327-.221-.548q-.221-.221-.548-.221H7.5v-2h4v-1h-2v-1h-1v1H7.27q-.328 0-.549.221q-.221.221-.221.548v2.462q0 .327.221.548q.221.221.548.221H10.5v2h-4v1h2v1Zm7.5-.52l1.538-1.538h-3.076L16 15.981Zm-1.538-6.172h3.076L16 8.269l-1.538 1.539Z" />
                                </svg>
                                <span>Price</span>
                            </label>
                        </div>

                        <div class="cust_input">
                            <input class="form-check-input" type="radio" value="multi_select"
                                id="data_type1_multi_select" name="data_type" />
                            <label class="form-check-label border" for="data_type1_multi_select">
                                <svg width="25" height="25" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20 2H8c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2zM8 16V4h12l.002 12H8z" />
                                    <path
                                        d="M4 8H2v12c0 1.103.897 2 2 2h12v-2H4V8zm8.933 3.519l-1.726-1.726l-1.414 1.414l3.274 3.274l5.702-6.84l-1.538-1.282z" />
                                </svg>
                                <span>Multi Select</span>
                            </label>
                        </div>

                        <div class="cust_input d-nones">
                            <input class="form-check-input" type="radio" value="diamension"
                                id="data_type1_diamension" name="data_type" />
                            <label class="form-check-label border" for="data_type1_diamension">
                                <svg width="25" height="25" viewBox="0 0 15 15"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M3 2.739a.25.25 0 0 1-.403.197L1.004 1.697a.25.25 0 0 1 0-.394L2.597.063A.25.25 0 0 1 3 .262v.74h6V.26a.25.25 0 0 1 .404-.197l1.592 1.239a.25.25 0 0 1 0 .394l-1.592 1.24A.25.25 0 0 1 9 2.738V2H3v.739ZM9.5 5h-7a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.5-.5Zm-7-1A1.5 1.5 0 0 0 1 5.5v7A1.5 1.5 0 0 0 2.5 14h7a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 9.5 4h-7Zm12.239 2H14v6h.739a.25.25 0 0 1 .197.403l-1.239 1.593a.25.25 0 0 1-.394 0l-1.24-1.593a.25.25 0 0 1 .198-.403H13V6h-.739a.25.25 0 0 1-.197-.403l1.239-1.593a.25.25 0 0 1 .394 0l1.24 1.593a.25.25 0 0 1-.198.403Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Dimension</span>
                            </label>
                        </div>

                        <div class="cust_input d-nosne">
                            <input class="form-check-input" type="radio" value="uom" id="data_type1_uom"
                                name="data_type" />
                            <label class="form-check-label border" for="data_type1_uom">
                                <svg width="25" height="25" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20.439 4.062h-9a.5.5 0 1 1 0-1h9a.5.5 0 0 1 0 1Zm0 5.624h-9a.5.5 0 0 1 0-1h9a.5.5 0 0 1 0 1Zm0 5.624h-9a.5.5 0 0 1 0-1h9a.5.5 0 0 1 0 1Zm0 5.624h-9a.5.5 0 0 1 0-1h9a.5.5 0 0 1 0 1ZM3.208 18.8a.5.5 0 0 1 .71-.71l1.14 1.14V4.775l-1.14 1.14a.513.513 0 0 1-.71 0a.5.5 0 0 1 0-.71l2-2a.494.494 0 0 1 .34-.14a.549.549 0 0 1 .37.14l2 2a.524.524 0 0 1 0 .71a.5.5 0 0 1-.71 0l-1.15-1.15v14.47l1.15-1.15a.5.5 0 1 1 .71.71l-2 2a.513.513 0 0 1-.71 0Z" />
                                </svg>
                                <span>UOM</span>
                            </label>
                        </div>

                        <div class="cust_input">
                            <input class="form-check-input" type="radio" value="url" id="data_type1_url"
                                name="data_type" />
                            <label class="form-check-label border" for="data_type1_url">
                                <svg width="40.3" height="25" viewBox="0 0 680 810"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M341 537q3 1 4 4t-1 6l-83 83q-20 20-46 32t-53 14t-54-4t-49-25q-27-21-42-51T1 536t9-61t34-54l129-129q31-31 72-46t84-8q38 6 60 22t35 37q2 5-.5 7.5T418 309t-7 6l-7 7q-10 11-24 11t-25.5-11.5T329 304t-31-5t-30 5t-27 18L93 470q-13 13-19 30t-4 34t10 34t26 27q25 17 54 12t49-24l64-63q2-3 6-1q30 13 62 18zM619 31q27 21 42 50t17 60t-9 62t-35 54L505 386q-31 31-72 45t-85 8q-38-5-59-22t-35-37q-2-4 1-7l18-18q11-10 25-10t24 10q12 12 27 18t31 6t31-6t26-18l148-147q13-13 19-31t4-35t-11-33t-26-27q-24-16-53-12t-50 25l-63 63q-3 3-6 1q-28-12-62-19q-4 0-4-4t1-5l83-83q20-20 46-32t52-15t54 5t50 25z" />
                                </svg>
                                <span>URL</span>
                            </label>
                        </div>

                        <div class="cust_input">
                            <input class="form-check-input" type="radio" value="html" id="data_type1_html"
                                name="data_type" />
                            <label class="form-check-label border" for="data_type1_html">
                                <svg width="25" height="25" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4 16v-2H2v2H1v-5h1v2h2v-2h1v5H4zm3 0v-4H5.6v-1h3.7v1H8v4H7zm3 0v-5h1l1.4 3.4h.1L14 11h1v5h-1v-3.1h-.1l-1.1 2.5h-.6l-1.1-2.5H11V16h-1zm9 0h-3v-5h1v4h2v1zM9.4 4.2L7.1 6.5l2.3 2.3l-.6 1.2l-3.5-3.5L8.8 3l.6 1.2zm1.2 4.6l2.3-2.3l-2.3-2.3l.6-1.2l3.5 3.5l-3.5 3.5l-.6-1.2z" />
                                </svg>
                                <span>HTML</span>
                            </label>
                        </div>

                        <div class="cust_input">
                            <input class="form-check-input" type="radio" value="interger" id="data_type1_interger"
                                name="data_type" />
                            <label class="form-check-label border" for="data_type1_interger">
                                <svg width="25" height="25" viewBox="0 0 32 32"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M26 12h-4v2h4v2h-3v2h3v2h-4v2h4a2.003 2.003 0 0 0 2-2v-6a2.002 2.002 0 0 0-2-2zm-7 10h-6v-4a2.002 2.002 0 0 1 2-2h2v-2h-4v-2h4a2.002 2.002 0 0 1 2 2v2a2.002 2.002 0 0 1-2 2h-2v2h4zM8 20v-8H6v1H4v2h2v5H4v2h6v-2H8z" />
                                </svg>
                                <span>Integer</span>
                            </label>
                        </div>

                    </div>
                </div>
                <div class="mb-3">
                    <input type="checkbox" name="must_field" id="must_field">
                    <label for="must_field">Required Field</label>
                </div>
            </div>


            <div class="col-12 col-md-8" id="value-field-bx" style="visibility:hidden;">
                <div class="value-field-bx">
                    <label class="btn"> Enter Values: </label>

                    <div class="mb-3">
                        <input type="text" placeholder="Enter Value" name="value[]"
                            class="form-control value-field">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-outline-primary" type="button" onclick="addValueField()" title="Or Just press 'Alt' + '+'">+ Add More</button>
                    </div>

                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-outline-primary">Create</button>
            </div>

        </div>



        <div class="row my-3">
            <div class="col-12">
                <div class="h6">Existing Columns</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($custom_fields as $field)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $field['text'] }}</td>
                                <td>
                                    <a href="#download" id="editCust" class="btn btn-outline-primary editCust" data-custid="{{ $field['id'] }}"  data-custname="{{ $field['text'] }}" data-values="{{ (is_array($field['value'])) ? implode(",",$field['value']) : $field['value'] }}" data-required="{{ $field['required'] ?? '' }}" data-data_type="{{ $field['data_type'] ?? '' }}" data-attr_section="{{ $field['ref_section'] }}" >Edit</a>

                                    <a href="{{ route('panel.settings.remove.custom.fields',encrypt($field['id'])) }}" class="btn btn-outline-danger delete-btn">Delete</a>

                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>


    </form>
</div>



<script>
    function checkRadio() {
        var radios = document.getElementsByName('data_type');
        var labels = document.getElementsByClassName('form-check-label');

        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                labels[i].classList.add('active');
            } else {
                labels[i].classList.remove('active');
            }
        }
    }

    function showDiv() {
        var radios = document.getElementsByName('data_type');
        var values = ['multi_select', 'select']; // Array of specific radio values

        var div = document.getElementById('value-field-bx');

        let checkedRadioButton;
        for (const radioButton of radios) {
            if (radioButton.checked) {
                checkedRadioButton = radioButton;
                break;
            }
        }

        // Print the value of the checked radio button
        if (checkedRadioButton) {
            console.log(checkedRadioButton.value);
        } else {
            console.log("No radio button is checked.");
        }

        if (values.includes(checkedRadioButton.value)) {
            div.style.visibility = 'visible';
            const valueFields = document.getElementsByClassName("value-field");
            for (const field of valueFields) {
                field.setAttribute("required", "true");
            }

            console.log("It Workded!!");
        } else {
            div.style.visibility = 'hidden';
            const valueFields = document.getElementsByClassName("value-field");
            for (const field of valueFields) {
                field.removeAttribute("required");
            }
            console.log("It Workded!!");
        }

    }

    var radioButtons = document.getElementsByName('data_type');
    for (var i = 0; i < radioButtons.length; i++) {
        radioButtons[i].addEventListener('click', function() {
            showDiv();
            checkRadio();
        });
    }

    function addValueField() {
        var valueField = document.createElement('div');
        valueField.classList.add('mb-3');
        valueField.innerHTML =
            '<input type="text" placeholder="Enter Value" name="value[]" class="form-control value-field">';
        document.querySelector('.value-field-bx').appendChild(valueField);
    }


    document.addEventListener('keydown', function(event) {
        if (event.altKey && event.key === '+') {
            // Call your function here
            addValueField();
        }

        if (event.ctrlKey && event.key === 'Enter') {
            // Validate the form here
            if (document.querySelector('form').checkValidity()) {
                document.querySelector('form').submit();
            } else {
                alert('Please fill all the required fields');
            }
        }
    });
</script>
