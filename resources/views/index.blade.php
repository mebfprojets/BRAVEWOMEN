<x-layouts>
<table class="table table-light">
    <thead>
        <th>URL</th>
        <th>UrlShorted</th>
    </thead>
    <tbody>
        @foreach ($urls as $url )
            <tr>
                <td>{{ $url->url }}</td>
                <td>{{ $url->shorteUrl }}</td>
            </tr>
        @endforeach

    </tbody>
</table>
</x-layouts>
