@extends('AdminDirectory.layout_admin')
@section('title')
    @if(!empty($product))
        {{$product->name}}
    @else
        Добавление товара
    @endif
@endsection
@section('main-content')
    <button onclick="window.location.href = '/admin-panel/products';">
        <iconify-icon icon="ep:back"></iconify-icon>
        Назад
    </button>
    <form id="description-form" enctype="multipart/form-data" method="POST" @if(!empty($product))
        action="{{ route('managment-product.update') }}"
    @else
        action="{{ route('managment-product.create') }}"
    @endif>
        @csrf
        @if(!empty($product))
            @method('PUT')
            <input hidden="hidden" value="{{$product->id}}" id="id" name="id">
        @endif
        <div>
            <div class="product-page">
                <div class="product-images">
                    <h6>Изображения:</h6>
                    <div style="display: flex">
                        <div class="main-image">
                            @if(!empty($product))
                                <a href="{{ asset('images/' . $product->main_image) }}" data-lightbox="product-images">
                                    <img style="max-width: 150px; max-height: 150px" id="mainImage" src="{{ asset('images/' . $product->main_image) }}" alt="{{ $product->name }}">
                                </a>
                            @endif
                            <div hidden="hidden" id="add-main-photo">
                                @if(empty($product))
                                    <input class="input-details" type="file" name="main_image" id="main_image" accept="image/*">
                                @endif
                            </div>
                        </div>
                        <div class="thumbnail-images" style="display: flex">
                            @if(!empty($product))
                                @foreach ($product->images as $image)
                                    <div>
                                        <a href="{{ asset('images/' . $image->photo_path) }}" data-lightbox="product-images">
                                            <img style="max-width: 50px; max-height: 50px" src="{{ asset('images/' . $image->photo_path) }}" alt="{{ $product->name }}" onclick="changeMainImage('{{ asset('images/' . $image->photo_path) }}')">
                                        </a>
                                        <button type="button" onclick="removeImage({{$image->id}})">Удалить</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div hidden="hidden" id="add-photo">
                        @if(!empty($product))
                            <h6>Добавить фото:</h6>
                            <input type="file" name="additional_images[]" multiple accept="image/*">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="product-details">
            <div style="display: flex">
                <div>
                    <div style="display: flex">
                        <h6 style="width: 20%;margin-right: 20px">Название:</h6>
                        <input style="width: 20%;margin-right: 20px" name="name" id="name" value="{{ $product->name ?? ''}}" disabled="disabled">
                    </div>
                    <div style="display: flex">
                        <h6 style="width: 20%;margin-right: 20px">Цена:</h6>
                        <input style="width: 20%;margin-right: 20px" name="price" id="price" value="{{$product->price ?? ''}}" disabled="disabled">
                    </div>
                    <div style="display: flex">
                        <h6 style="width: 20%;margin-right: 20px">Скидка (в процентах):</h6>
                        <input style="width: 20%;margin-right: 20px" name="discount" id="discount" value="{{$product->discount ?? ''}}" disabled="disabled">
                    </div>
                    <div style="display: flex">
                        <h6 style="width: 20%;margin-right: 20px">Количество на складе:</h6>
                        <input style="width: 20%;margin-right: 20px" name="quantity" id="quantity" value="{{$product->quantity ?? ''}}" disabled="disabled">
                    </div>
                    @if(!empty($product))
                        <div style="display: flex">
                            <h6 style="width: 20%;margin-right: 20px">Рейтинг:</h6>
                            <p> {{round($product->reviews_avg_star,2) ?? ''}}</p>
                        </div>
                    @endif
                </div>
                <div>
                    <div style="display: flex">
                        <h6 style="width: 40%;margin-right: 20px">Категория:</h6>
                        @if(!empty($product))
                            <input style="width: 40%;margin-right: 20px" name="category" id="category" value="{{$product->category()->with('products')->paginate(10)->items()[0]->name ?? ''}}" disabled="disabled">
                        @endif
                        <select hidden="hidden" id="category_id" name="category_id" style="width: 40%;border: 1px solid gray; border-radius: 5px; margin-left: 20px" onchange="categoryChange()">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ ($product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display: flex">
                        <h6 style="width: 40%;margin-right: 20px">Бренд:</h6>
                        @if(!empty($product))
                            <input style="width: 40%;margin-right: 20px" name="brand" id="brand" value="{{$product->brand()->with('products')->paginate(10)->items()[0]->name}}" disabled="disabled" >
                        @endif
                        <select hidden="hidden" id="brand_id" name="brand_id" style="width: 40% ;border: 1px solid gray; border-radius: 5px; margin-left: 20px" onchange="brandChange()">
                            @foreach($brands as $brand)
                                <option value="{{$brand->id}}" {{ ($product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{$brand->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display: flex">
                        <h6 style="width: 40%;margin-right: 20px">Производитель:</h6>
                        @if(!empty($product))
                            <input style="width: 40%;margin-right: 20px" name="manufacture" id="manufacture" value="{{$product->manufacture()->paginate(10)->items()[0]->name ?? ''}}" disabled="disabled">
                        @endif
                        <select hidden="hidden" id="manufacture_id" name="manufacture_id" style="width: 40%;border: 1px solid gray; border-radius: 5px;margin-left: 20px" onchange="manufactureChange()">
                            @foreach($manufactures as $manufacture)
                                <option value="{{$manufacture->id}}" {{ ($product->manufacture_id ?? '') == $manufacture->id ? 'selected' : '' }}>{{$manufacture->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <h6>Описание:</h6>
            <textarea id="summernote" name="description">{{$product->description ?? ''}}</textarea>
            <script>
                $('#summernote').summernote({
                    placeholder: 'Hello Bootstrap 4',
                    tabsize: 2,
                    height: 100,
                });
            </script>
        </div>
        <button id="redact-button" class="btn btn-primary" type="button" onclick="redactProduct()">Редактировать</button>
        <button id="cansel-save" class="btn btn-primary" hidden="hidden" type="button" onclick="canselRedact()" style="background: gray; border: 1px solid gray;margin-bottom: 20px">Отмена</button>
        <button hidden="hidden" id="save-button" class="btn btn-primary" type="submit">
            @if(!empty($product))
                Сохранить
            @else
                Добавить
            @endif
        </button>
    </form>
    @if(!empty($product))
        <form id="del-other-photo" method="POST" action="{{ route('managment-product-image.detele') }}">
            @csrf
            @method('DELETE')
            <input hidden="hidden" name="image_del_id" id="image_del_id">
            <input hidden="hidden" name="product_id" value="{{$product->id}}">
        </form>
    @endif
    <div>
        @if(!empty($product))
            <hr style="border: 1px solid gray">
            <h3>Технические характеристики</h3>
            @if(!empty($product->attributes_with_names))
                <table class="specs">
                    @foreach ($product->attributes_with_names as $attribute)
                        <tbody>
                            <tr>
                                <td>{{ $attribute['name'] }}: {{ $attribute['value'] }}</td>
                                <td><form method="POST" id="del-teh-attribute" action="{{route('managment-product-tech.detele')}}">
                                        @method('DELETE')
                                        @csrf
                                        <input hidden="hidden" value="{{$attribute['attribute_id']}}" name="attribute_id" id="attribute_id">
                                        <input hidden="hidden" value="{{$product->id}}" name="product_id" id="product_id">
                                        <button type="submit" class="profile-button">удалить</button>
                                    </form></td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            @endif
            <button id="add-teh-attribute-button" onclick="addTehAttribute()" class="profile-button" style="margin-left: 0px">Добавить атрибут</button>
            <form id="add-teh-attribute" method="POST" hidden="hidden" action="{{route('managment-product-tech.add')}}">
                @csrf
                <input hidden="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                <select id="attribute_id" name="attribute_id" style="border: 1px solid gray; border-radius: 5px; margin: 20px 0px 10px 0px">
                    @foreach($attributes as $attribute)
                        @php
                            $bool = true;
                        foreach ($product->attributes_with_names as $attribute_product)
                            if($attribute->id == $attribute_product['attribute_id'])
                                {
                                    $bool = false;
                                }
                        @endphp
                            @if($bool)
                                <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                            @endif
                    @endforeach
                </select>
                <input class="input-details" name="value" id="value">
                <button class="profile-button" type="submit" onclick="attributeAdd()">добавить</button>
            </form>
        @endif
    </div>
    <hr style="border: 1px solid gray">
    @if(!empty($product))
        <div class="related-products">
            <h3>Рекомендации по сопутствующим товарам</h3>
            <div class="recommend-wrapper">
                <button class="scroll-button prev-button">‹</button>
                <div class="recommend-products" id="recommendProducts">
                    @if(!empty($bonds_products->items()))
                        @foreach($bonds_products->items() as $bond_product)
                            <div class="product-item">
                                <div class="product-image">
                                    <a href="{{ route('product.index','id='. $bond_product['bond']->id) }}">
                                        <img src="{{ asset('images/' . $bond_product['bond']->main_image) }}" alt="{{ $bond_product['bond']->name }}">
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('product.index', $bond_product['bond']->id) }}">{{ $bond_product['bond']->name }}</a>
                                    @if($bond_product['bond']->discount > 0)
                                        @php
                                            $originalPrice = $bond_product['bond']->price;
                                            $discountedPrice = $originalPrice - ($originalPrice * ($bond_product['bond']->discount / 100));
                                        @endphp
                                        <p class="discounted-price">{{ number_format($discountedPrice, 2, ',', ' ') }} р.</p>
                                        <p class="original-price">{{ number_format($originalPrice, 2, ',', ' ') }} р.</p>
                                    @else
                                        <p>{{ $bond_product['bond']->price }}р.</p>
                                    @endif
                                    <form id="delete-product-bond" method="POST" action="{{route('managment-product-bond.delete')}}">
                                        @method('DELETE')
                                        @csrf
                                        <input hidden="hidden" name="bond_id" value="{{$bond_product['bond']->id}}">
                                        <input hidden="hidden" name="product_id" value="{{$product->id}}">
                                        <button type="submit" style="border-radius: 4px" class="submit-button">Удалить</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button class="scroll-button next-button">›</button>
            </div>
        </div>
        <div>
            <h3>Добавить рекомендации по сопутствующим товарам:</h3>
            <button class="profile-button" id="add-bond-button" style="margin-left: 0px" onclick="addBond()">Добавить</button>
            <div>
                <form hidden="hidden" id="add-product-bond" method="POST" action="{{route('managment-product-bond.add')}}">
                    @csrf
                    <input  hidden="hidden" name="product_id" value="{{$product->id}}">
                    <div>
                        <h6>Номер сопутствующим товара</h6>
                        <input class="input-details" placeholder="id" name="bond_id" type="number">
                    </div>
                    <button class="profile-button" style="margin-left: 0px;margin-top: 20px" onclick="saveBond()" type="submit">Сохранить</button>
                </form>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <script>
        function submitForm() {
            document.getElementById('paginate-form').submit();
        }
        function addBond()
        {
            document.getElementById('add-product-bond').hidden = false;
            document.getElementById('add-bond-button').hidden = true;
        }
        function saveBond()
        {
            document.getElementById('add-product-bond').hidden = true;
            document.getElementById('add-bond-button').hidden = false;
        }
        function addTehAttribute()
        {
            document.getElementById('add-teh-attribute').hidden = false;
            document.getElementById('add-teh-attribute-button').hidden = true;
        }
        function attributeAdd()
        {
            document.getElementById('add-teh-attribute-button').hidden = false;
            document.getElementById('add-teh-attribute').hidden = true;
        }
        function redactProduct()
        {
            document.getElementById('name').disabled = false;
            document.getElementById('price').disabled = false;
            document.getElementById('discount').disabled = false;
            document.getElementById('quantity').disabled = false;
            document.getElementById('category_id').hidden = false;
            document.getElementById('brand_id').hidden = false;
            document.getElementById('manufacture_id').hidden = false;
            document.getElementById('redact-button').hidden = true;
            document.getElementById('save-button').hidden = false;
            document.getElementById('add-photo').hidden = false;
            document.getElementById('add-main-photo').hidden = false;
            document.getElementById('cansel-save').hidden = false;
        }
        function canselRedact()
        {
            document.getElementById('name').disabled = true;
            document.getElementById('price').disabled = true;
            document.getElementById('discount').disabled = true;
            document.getElementById('quantity').disabled = true;
            document.getElementById('category_id').hidden = true;
            document.getElementById('brand_id').hidden = true;
            document.getElementById('manufacture_id').hidden = true;
            document.getElementById('redact-button').hidden = false;
            document.getElementById('save-button').hidden = true;
            document.getElementById('add-photo').hidden = true;
            document.getElementById('add-main-photo').hidden = true;
            document.getElementById('cansel-save').hidden = true;
        }
        function removeImage(imageId)
        {
            document.getElementById('image_del_id').value = imageId;
            document.getElementById('del-other-photo').submit();
        }
    </script>
@endsection
