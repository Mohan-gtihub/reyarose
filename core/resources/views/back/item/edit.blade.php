@extends('master.back')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <h3 class="mb-0 bc-title"><b>{{ __('Update Product') }}</b> </h3>
                    <a class="btn btn-primary   btn-sm" href="{{ route('back.item.index') }}"><i class="fas fa-chevron-left"></i> {{ __('Back') }}</a>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                @include('alerts.alerts')
            </div>
        </div>
        <!-- Nested Row within Card Body -->

        <form class="admin-form" action="{{ route('back.item.update', $item->id) }}" method="POST" enctype="multipart/form-data">

            @csrf

            @method('PUT')
            <div class="row">

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{ __('Name') }} *</label>
                                <input type="text" name="name" class="form-control item-name" id="name" placeholder="{{ __('Enter Name') }}" value="{{ $item->name }}">
                            </div>

                            <div class="form-group">
                                <label for="slug">{{ __('Slug') }} *</label>
                                <input type="text" name="slug" class="form-control" id="slug" placeholder="{{ __('Enter Slug') }}" value="{{ $item->slug }}">
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group pb-0  mb-0">
                                <label class="d-block">{{ __('Featured Image') }} *</label>
                            </div>
                            <div class="form-group position-relative ">
                                <label class="text-sm"><small>{{ __('Image Size Should Be 800 x 800. or square size') }}</small></label>
                                <div class="input-group" data-toggle="aizuploader" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ trans('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount {{ $errors->has('photo') ? ' is-invalid' : '' }}">{{ trans('Choose File') }}</div>
                                    <input type="hidden" name="photo" value="{{ isset($item) ? $item->photo : old('photo') }}" class="selected-files" required>
                                    @if ($errors->has('photo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('photo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="file-preview"></div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group pb-0  mb-0">
                                <label>{{ __('Gallery Images') }} </label>
                            </div>
                            <div class="form-group">
                                <label class="text-sm"><small>{{ __('Image Size Should Be 800 x 800. or square size') }}</small></label>
                                <div class="input-group" data-toggle="aizuploader" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            {{ trans('Browse') }}</div>
                                    </div>
                                    <div class="form-control file-amount {{ $errors->has('galleries') ? ' is-invalid' : '' }}">{{ trans('Choose File') }}</div>
                                    <input type="hidden" name="galleries" value="{{ isset($item) ? $item->galleries : old('galleries') }}" class="selected-files" required>
                                    @if ($errors->has('galleries'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('galleries') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="file-preview gallery-preview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="min-qty">{{ __('Minimum Qty') }}*</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="1" id="min-qty" name="min_qty" class="form-control" placeholder="{{ __('1') }}" value="{{ $item->min_qty }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="multiple">{{ __('Multiple') }}*</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="1" id="multiple" name="multiple" class="form-control" placeholder="{{ __('x1') }}" value="{{ $item->multiple }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="switch-primary">
                                    <input type="checkbox" class="switch switch-bootstrap status radio-check" name="is_bulk_discount" value="1" {{ $item->is_bulk_discount == 1 ? 'checked' : '' }}>
                                    <span class="switch-body"></span>
                                    <span class="switch-text">{{ __('Bulk discount') }}</span>
                                </label>
                            </div>
                            @php
                                $bulk_discounts = json_decode($item->bulk_discount);
                            @endphp
                            <div id="discount-items-section" class="{{ $item->is_bulk_discount == 0 ? 'd-none' : '' }}">
                                @if ($bulk_discounts && count($bulk_discounts) > 0)
                                    @foreach ($bulk_discounts as $discount)
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="items[]" placeholder="{{ __('Number of items') }}" value="{{ $discount->items }}">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="price[]" placeholder="{{ __('Price') }}" value="{{ $discount->price }}">
                                                </div>
                                            </div>
                                            <div class="flex-btn">
                                                @if ($loop->first)
                                                    <button type="button" class="btn btn-success add-discount-items" data-text="{{ __('Number of items') }}" data-text1="{{ __('Price') }}"> <i
                                                            class="fa fa-plus"></i> </button>
                                                @else
                                                    <button type="button" class="btn btn-danger remove-bluk-items" data-text="{{ __('Number of items') }}" data-text1="{{ __('Price') }}"> <i
                                                            class="fa fa-minus"></i> </button>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="items[]" placeholder="{{ __('Number of items') }}" value="">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="price[]" placeholder="{{ __('Price') }}" value="">
                                            </div>
                                        </div>
                                        <div class="flex-btn">
                                            <button type="button" class="btn btn-success add-discount-items" data-text="{{ __('Number of items') }}" data-text1="{{ __('100.0') }}"> <i
                                                    class="fa fa-plus"></i> </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="sort_details">{{ __('Short Description') }} *</label>
                                <textarea name="sort_details" id="sort_details" class="form-control" placeholder="{{ __('Short Description') }}">{{ $item->sort_details }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="details">{{ __('Description') }} *</label>
                                <textarea name="details" id="details" class="form-control text-editor" rows="6" placeholder="{{ __('Enter Description') }}">{{ $item->details }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="tags">{{ __('Product Tags') }}
                                </label>
                                <input type="text" name="tags" class="tags" id="tags" placeholder="{{ __('Tags') }}" value="{{ $item->tags }}">
                            </div>
                            <div class="form-group">
                                <label class="switch-primary">
                                    <input type="checkbox" class="switch switch-bootstrap status radio-check" name="is_specification" value="1"
                                        {{ $item->is_specification == 1 ? 'checked' : '' }}>
                                    <span class="switch-body"></span>
                                    <span class="switch-text">{{ __('Specifications') }}</span>
                                </label>
                            </div>

                            <div id="specifications-section" class="{{ $item->is_specification == 0 ? 'd-none' : '' }}">
                                @if (!empty($specification_name))
                                    @foreach (array_combine($specification_name, $specification_description) as $name => $description)
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="specification_name[]" placeholder="{{ __('Specification Name') }}" value="{{ $name }}">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="specification_description[]" placeholder="{{ __('Specification description') }}"
                                                        value="{{ $description }}">
                                                </div>
                                            </div>
                                            <div class="flex-btn">
                                                @if ($loop->first)
                                                    <button type="button" class="btn btn-success add-specification" data-text="{{ __('Specification Name') }}"
                                                        data-text1="{{ __('Specification Description') }}"> <i class="fa fa-plus"></i> </button>
                                                @else
                                                    <button type="button" class="btn btn-danger remove-spcification" data-text="{{ __('Specification Name') }}"
                                                        data-text1="{{ __('Specification Description') }}"> <i class="fa fa-minus"></i> </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="specification_name[]" placeholder="{{ __('Specification Name') }}" value="">
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="specification_description[]" placeholder="{{ __('Specification description') }}" value="">
                                            </div>
                                        </div>
                                        <div class="flex-btn">
                                            <button type="button" class="btn btn-success add-specification" data-text="{{ __('Specification Name') }}"
                                                data-text1="{{ __('Specification Description') }}"> <i class="fa fa-plus"></i> </button>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="meta_keywords">{{ __('Meta Keywords') }}
                                </label>
                                <input type="text" name="meta_keywords" class="tags" id="meta_keywords" placeholder="{{ __('Enter Meta Keywords') }}" value="{{ $item->meta_keywords }}">
                            </div>
                            <div class="form-group">
                                <label for="meta_description">{{ __('Meta Description') }}
                                </label>
                                <textarea name="meta_description" id="meta_description" class="form-control" rows="5" placeholder="{{ __('Enter Meta Description') }}">{{ $item->meta_description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" class="check_button" name="is_button" value="0">
                            <button type="submit" class="btn btn-secondary mr-2">{{ __('Update') }}</button>
                            <a class="btn btn-success" href="{{ route('back.attribute.index', $item->id) }}">{{ __('Manage Attributes') }}</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="discount_price">{{ __('Current Price') }}
                                    *</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $curr->sign }}</span>
                                    </div>
                                    <input type="text" id="discount_price" name="discount_price" class="form-control" placeholder="{{ __('Enter Current Price') }}" min="1" step="0.1"
                                        value="{{ round($item->discount_price * $curr->value, 2) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="previous_price">{{ __('Previous Price') }}
                                </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ $curr->sign }}</span>
                                    </div>
                                    <input type="text" id="previous_price" name="previous_price" class="form-control" placeholder="{{ __('Enter Previous Price') }}" min="1"
                                        step="0.1" value="{{ round($item->previous_price * $curr->value, 2) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_id">{{ __('Select Category') }} *</label>
                                <select name="category_id" id="category_id" data-href="{{ route('back.get.subcategory') }}" class="form-control">
                                    @foreach (DB::table('categories')->whereStatus(1)->get() as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == $item->category_id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="subcategory_id">{{ __('Select Sub Category') }} </label>
                                <select name="subcategory_id" id="subcategory_id" class="form-control" data-href="{{ route('back.get.childcategory') }}">
                                    <option value="">{{ __('Select one') }}</option>
                                    @foreach (DB::table('subcategories')->where('category_id', $item->category_id)->whereStatus(1)->get() as $subcat)
                                        <option value="{{ $subcat->id }}" {{ $subcat->id == $item->subcategory_id ? 'selected' : '' }}>{{ $subcat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="childcategory_id">{{ __('Select Child Category') }} </label>
                                <select name="childcategory_id" id="childcategory_id" class="form-control">
                                    <option value="">{{ __('Select one') }}</option>
                                    @foreach (DB::table('chield_categories')->where('category_id', $item->category_id)->whereStatus(1)->get() as $chieldcategory)
                                        <option value="{{ $chieldcategory->id }}" {{ $chieldcategory->id == $item->childcategory_id ? 'selected' : '' }}>{{ $chieldcategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brand_id">{{ __('Select Brand') }} </label>
                                <select name="brand_id" id="brand_id" class="form-control">
                                    <option value="" selected>{{ __('Select Brand') }}</option>
                                    @foreach (DB::table('brands')->whereStatus(1)->get() as $brand)
                                        <option value="{{ $brand->id }}" {{ $brand->id == $item->brand_id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="stock">{{ __('Total in stock') }}
                                    *</label>
                                <div class="input-group mb-3">
                                    <input type="number" id="stock" name="stock" class="form-control" placeholder="{{ __('Total in stock') }}" value="{{ $item->stock }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tax_id">{{ __('Select Tax') }} *</label>
                                <select name="tax_id" id="tax_id" class="form-control">
                                    <option value="">{{ __('Select One') }}</option>
                                    @foreach (DB::table('taxes')->whereStatus(1)->get() as $tax)
                                        <option value="{{ $tax->id }}" {{ $item->tax_id == $tax->id ? 'selected' : '' }}>{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sku">{{ __('SKU') }} *</label>
                                <input type="text" name="sku" class="form-control" id="sku" placeholder="{{ __('Enter SKU') }}" value="{{ $item->sku }}">
                            </div>
                            <div class="form-group">
                                <label for="video">{{ __('Vido Link') }} </label>
                                <input type="text" name="video" class="form-control" id="video" placeholder="{{ __('Enter Video Link') }}" value="{{ $item->video }}">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="length">{{ __('Length') }}*</label>
                                <div class="input-group mb-3">
                                    <input type="text" id="length" name="length" class="form-control" placeholder="{{ __('Item length') }}" value="{{ $item->length }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tax_id">{{ __('Breadth') }} *</label>
                                <input type="text" name="breadth" class="form-control" id="breadth" placeholder="{{ __('Item breadth') }}" value="{{ $item->breadth }}">
                            </div>
                            <div class="form-group">
                                <label for="height">{{ __('Height') }} *</label>
                                <input type="text" name="height" class="form-control" id="height" placeholder="{{ __('Item height') }}" value="{{ $item->height }}">
                            </div>
                            <div class="form-group">
                                <label for="weight">{{ __('Weight') }} *</label>
                                <input type="text" name="weight" class="form-control" id="weight" placeholder="{{ __('Item weight') }}" value="{{ $item->weight }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
    {{-- DELETE MODAL --}}

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Confirm Delete?') }}</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    {{ __('You are going to delete this image from gallery.') }} {{ __('Do you want to delete it?') }}
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="" class="d-inline btn-ok" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- DELETE MODAL ENDS --}}

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var filePreviewContainer = document.querySelector('.gallery-preview');
            var hiddenInput = document.querySelector('input[name="galleries"]');

            var sortable = Sortable.create(filePreviewContainer, {
                animation: 150,
                onEnd: function(evt) {
                    
                    updateHiddenInput();
                },
            });

            function updateHiddenInput() {
                var imageIds = [];
                var previewItems = filePreviewContainer.querySelectorAll('.file-preview-item');

                previewItems.forEach(function(item) {
                    imageIds.push(item.getAttribute('data-id'));
                });

                hiddenInput.value = imageIds.join(',');
            }

            
        });
    </script>
@endsection
