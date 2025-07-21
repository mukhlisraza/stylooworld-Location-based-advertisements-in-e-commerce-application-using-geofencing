<?php

use App\Brand;
use App\Section;

$sections = Section::sections();
$brands = Brand::brands();
// echo "pre";
// print_r($sections);
// die;
?>
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products" id="accordian">
            <!--category-productsr-->
            @foreach($sections as $section)
            @if(count($section['categories'])>0)
            </br>

            <div class="panel panel-default">
                <ul id="sideManu" class="nav nav-tabs nav-stacked">


                    <!-- onclick="window.location='http://127.0.0.1:8000/products'" -->
                    <li class="subMenu"><a id="categoryName"><span class="badge pull-right"><i class="fa fa-plus"></i></span>{{$section['name']}}</a>
                        @foreach($section['categories'] as $category)

                        <ul>
                            <li><a href="{{url($category['category_name'])}}" id="category">{{$category['category_name']}}</a></li>
                            @foreach($category['subcategories'] as $subcategory)
                            <li><a href="{{url($subcategory['category_name'])}}" id="subCategory">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i> {{$subcategory['category_name']}}</a></li>
                            @endforeach
                        </ul>

                        @endforeach
                    </li>

                </ul>
            </div>
            @endif
            @endforeach
        </div>
        <!--/category-products-->
        @if(isset($page_name)&&$page_name=="listing")
        <div class="brands_products">
            <!--brands_products-->
            <h2>Brands</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">

                    @foreach($brandArray as $brand)
                    &nbsp; &nbsp; &nbsp; <input class="brand" type="checkbox" name="brand[]" id="{{$brand}}" value="{{$brand}}">&nbsp; &nbsp; &nbsp;{{$brand}}<br>
                    @endforeach
                </ul>

            </div>

        </div>

        <!-- <div class="brands_products">
            
            <h2>Other Filters</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">

                    <h2>
                        <li><a href="#">Fabric</a></li>
                    </h2>
                    @foreach($fabricArray as $fabric)
                    &nbsp; &nbsp; &nbsp; <input class="fabric" type="checkbox" name="fabric[]" id="{{$fabric}}" value="{{$fabric}}">&nbsp; &nbsp; &nbsp;{{$fabric}}<br>
                    @endforeach

                    <h2>
                        <li><a href="#">Sleeve</a></li>
                    </h2>
                    @foreach($sleeveArray as $sleeve)
                    &nbsp; &nbsp; &nbsp; <input class="sleeve" type="checkbox" name="sleeve[]" id="{{$sleeve}}" value="{{$sleeve}}">&nbsp; &nbsp; &nbsp;{{$sleeve}}<br>
                    @endforeach

                    <h2>
                        <li><a href="#">Pattern</a></li>
                    </h2>
                    @foreach($patternArray as $pattern)
                    &nbsp; &nbsp; &nbsp; <input class="pattern" type="checkbox" name="pattern[]" id="{{$pattern}}" value="{{$pattern}}">&nbsp; &nbsp; &nbsp;{{$pattern}}<br>
                    @endforeach

                    <h2>
                        <li><a href="#">Fit</a></li>
                    </h2>
                    @foreach($fitArray as $fit)
                    &nbsp; &nbsp; &nbsp; <input class="fit" type="checkbox" name="fit[]" id="{{$fit}}" value="{{$fit}}">&nbsp; &nbsp; &nbsp;{{$fit}}<br>
                    @endforeach

                    <h2>
                        <li><a href="#">occasion</a></li>
                    </h2>
                    @foreach($occasionArray as $occasion)
                    &nbsp; &nbsp; &nbsp; <input class="occasion" type="checkbox" name="occasion[]" id="{{$occasion}}" value="{{$occasion}}">&nbsp; &nbsp; &nbsp;{{$occasion}}<br>
                    @endforeach

                </ul>

            </div>
            <br>
        </div> -->
        @endif
        <!--/brands_products-->


    </div>
</div>