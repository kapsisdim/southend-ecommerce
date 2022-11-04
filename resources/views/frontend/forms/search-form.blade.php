<!-- Search Form -->
<div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
<!-- Search Form -->
<div class="search-top">
    <form class="search-form">
        <input type="text" placeholder="Search here..." name="search">
        <button value="search" type="submit"><i class="ti-search"></i></button>
    </form>
</div>
<!--/ End Search Form -->
<div class="search-bar-top">
    <div class="search-bar">
        <select>
            <option >All Category</option>
            @foreach(Helper::getAllCategory() as $cat)
                <option>{{$cat->title}}</option>
            @endforeach
        </select>
        <form method="POST" action="{{route('product.search')}}">
            @csrf
            <input name="search" placeholder="Search Products Here....." type="search">
            <button class="btnn" type="submit"><i class="ti-search"></i></button>
        </form>
    </div>
</div>
