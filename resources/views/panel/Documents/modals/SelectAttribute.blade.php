<div class="modal fade" id="AttriModal" tabindex="-1" aria-labelledby="AttriModalLabel" aria-hidden="true" style="z-index: 99999999">
    <div class="modal-dialog" style="background-color:#ffff; max-width:1300px !important;">
        <div class="modal-content" style="margin-top:0%;">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="AttriModalLabel">Select Columns</h6>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="col-lg-12 col-md-6 col-12 my-3" style="overflow: auto; max-height: 80vh">

                    <div class="row">

                        <div class="col-12 accordion" >
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="btn shadow-none accordion-button" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Variant Basis
                                  </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show">
                                  <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <div
                                                style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                                <input type="checkbox" name="column-{{ _('description') }}[]"
                                                    id="column-{{ _('description_col') }}" class="choosefields mx-2"
                                                    @if (searchElement('description', $selected_cols)) checked @endif
                                                    >
                                                <label for="column-{{ _('description_col') }}"
                                                    class="mb-0">{{ _('Description') }}</label>
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div
                                                style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                                <input type="checkbox" name="column-{{ _('pnotes') }}[]"
                                                    id="column-{{ _('pnotes_col') }}" class="choosefields mx-2"
                                                    @if (searchElement('Notes', $selected_cols)) checked @endif
                                                    >
                                                <label for="column-{{ _('pnotes_col') }}"
                                                    class="mb-0">{{ _('Notes') }}</label>
                                            </div>
                                        </div>


                                        @foreach (json_decode($user->custom_attriute_columns) as $item)
                                            @php
                                                $tmp_name = preg_replace('/[\s\[\]().]/', '', str_replace('.', '-', $item));
                                                $tmp_ID = str_replace(',', '', $tmp_name);
                                            @endphp
                                            <div class="col-3">
                                                <div
                                                    style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                                    <input type="checkbox" name="column-{{ $tmp_name }}[]"
                                                        id="column-{{ $tmp_ID }}" class="choosefields mx-2"
                                                        @if (searchElement($item, $selected_cols)) checked @endif
                                                        >
                                                    <label for="column-{{ $tmp_ID }}"
                                                        class="mb-0">{{ $item }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                  </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="btn shadow-none accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Essentials
                                  </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse">
                                  <div class="accordion-body">
                                    <div class="row">
                                        @php
                                            $chksection1 = 0;
                                            $chksection4 = 0;
                                            $chksection5 = 0;
                                        @endphp
                                        @foreach ($custom_inputs as $item)
                                            @php
                                                $tmp_name = preg_replace('/[\s\[\]().]/', '', str_replace('.', '-', $item->id));
                                                $tmp_ID = str_replace(',', '', $tmp_name);
                                            @endphp

                                            @if ($item->ref_section === '4')
                                                @php
                                                    $chksection4 = 1;
                                                @endphp
                                            @endif
                                            @if ($item->ref_section === '5')
                                                @php
                                                    $chksection5 = 1;
                                                @endphp
                                            @endif
                                            @if ($item->ref_section !== '1')
                                                @php
                                                    $chksection1 = 1;
                                                @endphp
                                                @continue
                                            @endif


                                            @php
                                                $chksection1 = 1;
                                            @endphp

                                            <div class="col-3">
                                                <div
                                                    style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                                    <input type="checkbox" name="column-{{ $tmp_name }}[]"
                                                        id="column-{{ $tmp_name }}" class="choosefields mx-2"
                                                        @if (searchElement($item->text, $selected_cols)) checked @endif

                                                        >
                                                    <label for="column-{{ $tmp_name }}"
                                                        class="mb-0">{{ $item->text }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                  </div>
                                </div>
                            </div>

                            <div class="accordion-item @if ($chksection4 == 0) d-none @endif">
                                <h2 class="accordion-header">
                                  <button class="btn shadow-none accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Internal - Reference
                                  </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse">
                                  <div class="accordion-body">
                                    <div class="row">
                                        @foreach ($custom_inputs as $item)
                                            @php
                                                $tmp_name = preg_replace('/[\s\[\]().]/', '', str_replace('.', '-', $item->id));
                                                $tmp_ID = str_replace(',', '', $tmp_name);
                                            @endphp

                                            @if ($item->ref_section !== '4')
                                                @continue
                                            @endif

                                            <div class="col-3">
                                                <div
                                                    style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                                    <input type="checkbox" name="column-{{ $tmp_name }}[]"
                                                        id="column-{{ $tmp_name }}" class="choosefields mx-2"
                                                        @if (searchElement($item->text, $selected_cols)) checked @endif

                                                        >
                                                    <label for="column-{{ $tmp_name }}"
                                                        class="mb-0">{{ $item->text }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                  </div>
                                </div>
                            </div>

                            <div class="accordion-item  @if ($chksection5 == 0) d-none @endif">
                                <h2 class="accordion-header">
                                  <button class="btn shadow-none accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Internal - Production
                                  </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse">
                                  <div class="accordion-body">
                                    <div class="row">
                                        @forelse ($custom_inputs as $item)
                                            @php
                                                $tmp_name = preg_replace('/[\s\[\]().]/', '', str_replace('.', '-', $item->id));
                                                $tmp_ID = str_replace(',', '', $tmp_name);
                                            @endphp

                                            @if ($item->ref_section !== '5')
                                                @continue
                                            @endif

                                            <div class="col-3">
                                                <div
                                                    style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                                    <input type="checkbox" name="column-{{ $tmp_name }}[]"
                                                        id="column-{{ $tmp_name }}" class="choosefields mx-2">
                                                    <label for="column-{{ $tmp_name }}"
                                                        class="mb-0">{{ $item->text }}</label>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-3">
                                                <div
                                                    style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                                    <label class="mb-0">Nothing To Show Here..</label>
                                                </div>
                                            </div>
                                        @endforelse


                                    </div>
                                  </div>
                                </div>
                            </div>


                        </div>


                    </div>

                </div>

            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary ml-auto" data-bs-dismiss="modal">Proceed</button>
            </div>


        </div>
    </div>
</div>
