<ul class="tabs">
    <li class="tab col s3">
        <a class="active teal-text text-darken-3" href="#fish">Рыба <b>({{ $count_fish }})</b></a>
    </li>
    <li class="tab col s2">
        <a href="#equipment" class="teal-text text-darken-3">Оборудывание <b>({{ $count_equipment }})</b></a>
    </li>
    <li class="tab col s2">
        <a href="#feed" class="teal-text text-darken-3">Корма <b>({{ $count_feed }})</b></a>
    </li>
    <li class="tab col s2">
        <a href="#chemistry" class="teal-text text-darken-3">Химия <b>({{ $count_chemistry }})</b></a>
    </li>
    <li class="tab col s2">
        <a href="#aquariums" class="teal-text text-darken-3">Аквариумы <b>({{ $count_aquariums }})</b></a>
    </li>
</ul>

@if ($price)
    <div id="fish" class="col s12">
        <x-price-tab-content
            :categories="$price->fish"
            names="Артикль,Название,Цена,Размер"
            keys="article,name,price,size"
            header="fish"
        ></x-price-tab-content>
    </div>
    <div id="equipment" class="col s12">
        <x-price-tab-content
            :categories="$price->equipment"
            names="Артикль,Название,Описание,Производитель,Цена"
            keys="article,name,description,producer,price"
            header="equipment"
        ></x-price-tab-content>
    </div>
    <div id="feed" class="col s12">
        <x-price-tab-content
            :categories="$price->feed"
            names="Артикль,Название,Описание,Упаковка,Цена"
            keys="article,name,description,weight,price"
            header="feed"
        ></x-price-tab-content>
    </div>
    <div id="chemistry" class="col s12">
        <x-price-tab-content
            :categories="$price->chemistry"
            names="Артикль,Название,Производитель,Описание,Цена"
            keys="article,name,capacity,description,price"
            header="chemistry"
        ></x-price-tab-content>
    </div>
    <div id="aquariums" class="col s12">
        <x-price-tab-content
            :categories="$price->aquariums"
            names="Артикль,Название,Обьем,Описание,Цена"
            keys="article,name,capacity,description,price"
            header="aquariums"
        ></x-price-tab-content>
    </div>
@else
    <div class="center" style="padding-top: 100px">
        <a href="{{ action('PriceListController@index') }}" class="btn teal darken-1">
            Перейти к загрузке прайса
        </a>
    </div>
@endif
