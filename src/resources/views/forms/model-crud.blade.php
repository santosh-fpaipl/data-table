@extends('panel::layouts.datatable')

@section('content')

    @if ($formType == 'advance_delete')
    
        <div class="list-group">

            {{-- @livewire($modelName.'.'.$modelName.'-delete',[$modelName => $model,'formType' => $formType]) --}}

            <livewire:delete 
                :model="$model"
                :modelClass="$modelClass"
                :datatableClass="$datatable"
                :formType="$formType"
                :returnURL="$returnURL"
                :key="Str::plural($modelName, 2) . '-delete-' . now()"
            />

                
        </div>

    @else
    
        <div>

            <div class="d-flex align-items-center">
                
                {{-- Back --}}
                {{-- <a href="{{ route(Str::plural($modelName) . '.index',['page'=>request()->query('page'),'from' =>'crud' ]) }}">
                    <button type="button" class="btn"><i class="bi bi-arrow-left"></i></button>
                </a> --}}
                
                {{-- Form Title --}}
                {{-- <p class="fs-5 fw-bold mb-0">{{ $messages[ $formType . '_page'] }}</p> --}}
                
                {!! createBreadcrum($modelName, $formType) !!}
                
                @push('page-title')
                    {{ $messages[ $formType . '_page'] }}
                @endpush
            </div>


            <hr>

            @if ($formType != 'show')

                <form 
                    method="post"
                    enctype="multipart/form-data" 
                    action="{{ route(Str::plural($modelName) . ($formType == 'create' ? '.store' : '.update'), $model) }}">
                    @csrf

            @endif

                    @if ($formType == 'edit')
                        @method('PUT')
                        <input type="hidden" name="model" value="{{ $model->id }}">
                        <input type="hidden" name="current_page_no" value="{{ $current_page_no }}" />
                    @endif

                    @foreach($fields as $field)

                        @if (!$field['artificial'])

                            {{-- Descriptions:
                                $field['fillable']['component'] : It is a component name used to create the input field.
                                $field['fillable']['type'] : It is a type's value of input field like text, file etc.
                                $field['name'] : It is field name of table of database.
                                $field['labels']['table'] : It ia used as label.
                                $field['fillable']['style'] : It is class name.
                                $field['fillable']['placeholder'] : It is a placeholder value of input field.
                                $field['fillable']['attributes'] : It is a array of arttibutes values of input fields.
                                $field['fillable']['rows'] : Number of rows in textarea
                            --}}

                            @include('panel::includes.' .$field['fillable']['component'], [
                                'type' => $field['fillable']['type'],
                                'options' => isset($field['fillable']['options']) ? $field['fillable']['options'] : null,
                                'name' => $field['name'], 
                                'model' => $model,
                                'show' => $formType == 'show' ? true : false,
                                'label' => $field['labels']['table'],
                                'style' => $field['fillable']['style'], 
                                'placeholder' => $field['fillable']['placeholder'],
                                'attribute' => $field['fillable']['attributes'],
                                'rows'=> $field['fillable']['rows'],
                            ])

                        @endif

                    @endforeach

            @if ($formType == 'show')
                <hr>

                @if ($model instanceOf App\Models\Product)
                    <div class="mb-3">
                        <div>
                            <livewire:color-image-size wire:key="now()"  :productId="$model->id" />
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div>
                            <livewire:product-attribute wire:key="now()" :productId="$model->id" />
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div>
                            <livewire:size-chart wire:key="now()" :productId="$model->id" />
                        </div>
                    </div>
                @endif

                @if ($model instanceOf App\Models\Collection)
                    <div class="mb-3">
                        <div>
                            <livewire:collection-have-product wire:key="now()"  :collectionId="$model->id" />
                        </div>
                    </div>
                @endif

                @if ($model instanceOf App\Models\Order)

                    <div class="mb-3">
                        <div>
                            <livewire:order-products wire:key="now()"  :orderId="$model->id" />
                        </div>
                    </div>

                    <hr>
                    
                    <div class="mb-3">
                        <div>
                            <livewire:order-update wire:key="now()"  :orderId="$model->id" />
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <div>
                            <livewire:delivery-create wire:key="now()"  :orderId="$model->id" />
                        </div>
                    </div>

                @endif

                @if ($model instanceOf App\Models\Delivery)
                    <div class="mb-3">
                        <div>
                            <livewire:delivery-update wire:key="now()"  :deliveryId="$model->id" />
                        </div>
                    </div>
                @endif

                @if ($model instanceOf App\Models\Payment)
                    <div class="mb-3">
                        <div>
                            <livewire:payment-update wire:key="now()"  :paymentId="$model->id" />
                        </div>
                    </div>
                @endif

                

                <hr>
                
                <x-panel-dependent-model :model="$model" />
            
            @else
                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn px-3 btn-secondary">Reset</button>
                        <button type="submit" class="btn px-3 btn-primary">{{ $formType == 'create' ? 'Save & New' : 'Update Details' }}</button>
                    </div>
                </form>
            @endif

        </div>
        
    @endif

@endsection