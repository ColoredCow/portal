<tr>
    <td class="w-60p" style = "padding-left:{{ $depth * 20 }}px">
        <span class="font-weight-bold">{{ $parameter->name }}</span>

        <ul>
            @foreach($parameter->options as $option)
            <li> {{ $option->value }} </li>
            @endforeach
        </ul>
    </td>
    <td>
        <h5>{{ $parameter->marks }}</h5>
    </td>
    <td>
        <button v-on:click="editParameter({{ $parameter}})" class="btn btn-sm btn-theme-gray-light">Edit</button>

        <button type="button" v-on:click="assignParentParameter({{ $parameter }})"
            class="ml-5 btn btn-sm btn-theme-gray-dark">Assign Parent</button>
    </td>
</tr>


@foreach($parameter->children ?:[] as $childParameter)
    @include('hr::evaluation.parameters.render-parameter', ['parameter' => $childParameter, 'depth' => $depth + 1])
@endforeach

