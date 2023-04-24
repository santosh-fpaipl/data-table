<div>

    <!-- Action Bar -->
    <!-- It shows the  some features like Add, Import, Download Sample, Export, Bulk Delete, Bulk Restore -->
    <div class="d-flex mb-3">
        @foreach ($buttonsTop as $button)
            @if ($button['show'][$activePage])
                @include('features::includes.' . $button['type'], [
                    'title' => $button['label'],
                    'style' => $button['style'],
                    'action' => $button['route'] ? $button['route'] : $button['function'],
                    'data' => Str::afterLast($model, '\\'), 
                ])
            @endif
        @endforeach
    </div>    

    <!-- Search, Alert & Filter Bar -->
    <div class="d-flex justify-content-between mb-3">

        <!-- It shows the  search feature. -->
        @if ($features['search']['show'][$activePage])
            <div class="me-auto">

                @include('features::includes.' .$features['search']['type'], [
                    'function' => $features['search']['attributes'],
                    'placeholder' => $features['search']['label'],
                ])

            </div>
        @endif

        <!-- BULK DELETE - It shows the total number of selected records. -->
        @if($features['bulk_actions']['show'][$activePage] && count($selectedRecords))
            <div class="flex-fill d-flex justify-content-center">
                <x-features-selected-records-alert-box
                    type="primary"
                    message="Selected {{ count($selectedRecords) }} rows"
                />
            </div>
        @endif

        <!-- It shows the  Filter Column feature. -->
        @if ($features['column_filter']['show'][$activePage])
            @include('features::includes.' . $features['column_filter']['type'])
        @endif
    </div>

    <!-- Data Table -->
    <table class="table" id="expandCollapse">
        <thead>
            <tr class="w-100">
                <!-- 
                    BULK DELETE 
                    It gives the feature to select "Active Page" and "All Page"
                -->
                @if ($features['bulk_actions']['show'][$activePage] && $data->isNotEmpty())
                    <th scope="col">

                        {{-- @include('features::includes.' .$features['bulk_actions']['type'], [
                            'labels' => $features['bulk_actions']['labels']
                        ]) --}}
                        <x-features-bulk-select  
                            :modelName="$modelName"
                            :labels="$features['bulk_actions']['labels']"
                            :selectPage="$selectPage"
                            :selectAll="$selectAll"
                        />

                    </th>
                @endif

                @foreach ($fields as $field)
                    @if ($field['viewable'][$activePage])
                        @include('features::includes.' .$field['thead']['view'], [
                            'name' => $field['name'],
                            'label'=> $field['labels']['table'],
                            'sortable' => $field['sortable'],
                            'align' => $field['thead']['align']?:'start',
                        ])
                    @endif
                @endforeach

                 <!-- ROW ACTIONS -->
                 @if ($rowActionsEnabled)
                        @include('features::includes.' .$field['thead']['view'], [
                            'label' => 'Action',
                            'sortable' => false,
                            'align' =>'center'
                        ])
                 @endif

            </tr>
        </thead>
        <tbody>
            @if ($data->isEmpty())
                <tr class="w-100">
                    <td colspan="{{ $visiblefields }}">
                        {{ $messages['no_record_found'] }}
                    </td>
                </tr>
            @else
                @foreach ($data as $model)
                
                    <tr class="w-100">

                         <!-- Bulk Action SelectBox for delete -->
                        @if ($features['bulk_actions']['show'][$activePage])
                            <td>
                                @include('features::includes.others.row-checkbox')
                            </td>
                        @endif

                        <!-- Data Row -->
                        @foreach ($fields as $field)
                            @if ($field['viewable'][$activePage])
                                <td>
                                    @include('features::includes.' .$field['tbody']['view'], [
                                        'iteration'=> $loop->parent->iteration,
                                        'name' => $field['name'],
                                        'value' => $field['tbody']['value'] ?: null,
                                        'align' => $field['tbody']['align']?:'start',
                                    ])
                                </td>
                            @endif
                        @endforeach

                         <!-- Row Action Buttons -->
                         @if ($features['row_actions']['show']['view'][$activePage] ||
                            $features['row_actions']['show']['edit'] || 
                            $features['row_actions']['show']['delete'])
                            <td class="text-center">
                                @include('features::includes.' . $features['row_actions']['type']['buttons'])
                            </td>
                        @endif

                    </tr>

                    <!-- Expandable View by Row Action -->
                    @if (Str::afterLast($buttonsTable['view']['type'], 'action-') == 'toggle')
                        @include('features::includes.' . $features['row_actions']['type']['collapse'])
                    @endif

                @endforeach
            @endif

        </tbody>
    </table>

    <!-- Pagination -->
    @if ($features['pagination']['show'][$activePage])
        @include('features::includes.' . $features['pagination']['type'])
    @endif

</div>
