<div class="row">
    <div class="col s12">
        <ul class="collapsible">
            @foreach ($categories as $category => $items)
                <li class="{{ $loop->index === 0 ? 'active' : '' }}">
                    <div class="collapsible-header">
                        <i class="material-icons teal-text text-darken-2">arrow_drop_down</i>
                        <b class="teal-text text-darken-2" style="margin-right:5px">
                            {{ App\Helper::countArrayItems($items) }}
                        </b>
                        {{ $category }}
                    </div>

                    <div class="collapsible-body">
                        <table class="striped responsive-table">
                            <thead>
                            <tr>
                                @foreach ($names as $name)
                                    <th>{{ $name }}</th>
                                @endforeach
                                <th>Изображение</th>
                                <th>Выбрать</th>
                            </tr>
                            </thead>
                            <tbody class="striped">
                                @foreach ($items as $item)
                                    @php
                                        $rand = random_int(0, 99999);
                                    @endphp
                                    @isset($item['article'])
                                        <tr>
                                            @foreach ($keys as $key)
                                                <td>{{ $item[$key] }}</td>
                                            @endforeach
                                            <td class="center">
                                                <img data-src="{{ $item['image'] ?? '' }}"
                                                     height="60"
                                                     class="smooth-loader z-depth-1"
                                                     id="image-{{ $loop->index }}-{{ $rand }}"
                                                >
                                            </td>
                                            <td>
                                                <form>
                                                    <input type="file"
                                                           style="display: none"
                                                           id="input-{{ $loop->index }}-{{ $rand }}"
                                                           class="_upload-image"
                                                           data-article="{{ $item['article'] }}"
                                                           data-image="image-{{ $loop->index }}-{{ $rand }}"
                                                           data-category="{{ $header }}"
                                                    >

                                                    <label
                                                            class="upload-image"
                                                            title="Выбрать изображение"
                                                            for="input-{{ $loop->index }}-{{ $rand }}"
                                                    >
                                                        <img src="{{ asset('storage/upload-image.png') }}"
                                                             alt="upload"
                                                             width="30"
                                                             height="30"
                                                        >
                                                    </label>
                                                </form>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($item as $single)
                                            @php
                                                $rand = random_int(0, 99999);
                                            @endphp
                                            <tr>
                                                @foreach ($keys as $key)
                                                    <td>{{ $single[$key] }}</td>
                                                @endforeach
                                                <td class="center">
                                                    <img data-src="{{ $single['image'] ?? '' }}"
                                                         height="60"
                                                         class="smooth-loader z-depth-1"
                                                         id="image-{{ $loop->index }}-{{ $rand }}"
                                                    >
                                                </td>
                                                <td>
                                                    <form>
                                                        <input type="file"
                                                               style="display: none"
                                                               id="input-{{ $loop->index }}-{{ $rand }}"
                                                               class="_upload-image"
                                                               data-article="{{ $single['article'] }}"
                                                               data-image="image-{{ $loop->index }}-{{ $rand }}"
                                                               data-category="{{ $header }}"
                                                        >

                                                        <label
                                                                class="upload-image"
                                                                title="Выбрать изображение"
                                                                for="input-{{ $loop->index }}-{{ $rand }}"
                                                        >
                                                            <img src="{{ asset('storage/upload-image.png') }}"
                                                                 alt="upload"
                                                                 width="30"
                                                                 height="30"
                                                            >
                                                        </label>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
