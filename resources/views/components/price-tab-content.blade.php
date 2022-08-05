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
                                    @php
                                        $rand = random_int(0, 99999);
                                    @endphp
                                    @isset($item['article'])
                                        <tr>
                                            @foreach ($keys as $key)
                                                @if (isset($item[$key]) && !is_array($item[$key]))
                                                    <td>{{ $item[$key] }}</td>
                                                @else
                                                    <td>?</td>
                                                @endif
                                            @endforeach
                                            <td class="center">
                                                <img data-src="{{ $item['image'] ?? '' }}"
                                                     height="60"
                                                     class="smooth-loader z-depth-1"
                                                     id="image-{{ $loop->index }}-{{ $rand }}"
                                                >
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($item as $single)
                                            @php
                                                $rand = random_int(0, 99999);
                                            @endphp
                                            <tr>
                                                @foreach ($keys as $key)
                                                    @if(isset($single[$key]) && !is_array($single[$key]))
                                                        <td>{{ $single[$key] }}</td>
                                                    @else
                                                        <td>?</td>
                                                    @endif
                                                @endforeach

                                                <td class="center">
                                                    <img data-src="{{ $single['image'] ?? '' }}"
                                                         height="60"
                                                         class="smooth-loader z-depth-1"
                                                         id="image-{{ $loop->index }}-{{ $rand }}"
                                                    >
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
