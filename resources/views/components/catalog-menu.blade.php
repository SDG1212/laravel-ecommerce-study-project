<div id="catalog-menu" class="header__desktop-menu catalog-menu">
  <button id="catalog-menu__toggle" class="catalog-menu__toggle" href="#">Каталог товаров</button>
  <div class="catalog-menu__wrapper">
    <ul class="dropdown-menu">
      @foreach ($categories as $category)
        <li class="dropdown-menu__item"><a class="dropdown-menu__item-link" href="{{ $category->url }}">{{ $category->name }}</a></li>
      @endforeach
    </ul>
  </div>
</div>
