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
                            </tr>
                            </thead>
                            <tbody class="striped">
                                @foreach ($items as $item)
                                    @isset($item['article'])
                                        <tr>
                                            @foreach ($keys as $key)
                                                <td>{{ $item[$key] }}</td>
                                            @endforeach
                                            <td>
                                                <div data-width="120"
                                                     class="async-load spinner"
                                                     data-async-load="{{ $item['image'] ?? '' }}"
                                                     data-class="z-depth-1"
                                                     data-id="image-{{ $loop->index }}-{{ $header }}"
                                                ></div>
                                            </td>
                                            <td>
                                                <form>
                                                    <input type="file"
                                                           style="display: none"
                                                           id="input-{{ $loop->index }}-{{ $header }}"
                                                           class="_upload-image"
                                                           data-article="{{ $item['article'] }}"
                                                           data-image="image-{{ $loop->index }}-{{ $header }}"
                                                           data-category="{{ $header }}"
                                                    >

                                                    <label
                                                            class="upload-image"
                                                            title="Выбрать изображение"
                                                            for="input-{{ $loop->index }}-{{ $header }}"
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
                                            <tr>
                                                @foreach ($keys as $key)
                                                    <td>{{ $single[$key] }}</td>
                                                @endforeach
                                                <td>
                                                    <div data-width="120"
                                                         class="async-load spinner"
                                                         data-async-load="{{ $single['image'] ?? '' }}"
                                                         data-class="z-depth-1"
                                                         data-id="image-{{ $loop->index }}-{{ $header }}"
                                                    ></div>
                                                </td>
                                                <td>
                                                    <form>
                                                        <input type="file"
                                                               style="display: none"
                                                               id="input-{{ $loop->index }}-{{ $header }}"
                                                               class="_upload-image"
                                                               data-article="{{ $single['article'] }}"
                                                               data-image="image-{{ $loop->index }}-{{ $header }}"
                                                               data-category="{{ $header }}"
                                                        >

                                                        <label
                                                                class="upload-image"
                                                                title="Выбрать изображение"
                                                                for="input-{{ $loop->index }}-{{ $header }}"
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
