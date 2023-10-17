<div class="row">
    <div class="col-md-12">
        <h4 class="card-title">
            <img class="mr-1" src="{{ asset($icon_class) }}" alt="file-icon"
                style="max-width: 35px;">{{ $file->name . '.' . $file->ext }}
    </div>
    <div class="col-md-12">
        <div>
            @foreach ($file_data as $fd)
                <div class="d-sm-inline-block d-block pr-1 pl-1 border-right">{{ $fd['label'] }}<label>:
                        {{ $fd['value'] }}</div>
            @endforeach
            @if (auth()->user()->role->name == 'Administrator' ||
                    auth()->user()->permissions->contains('name', 'Download File'))
                <div class="d-sm-inline-block d-block pr-1 pl-1 border-right"><a
                        href="{{ route('home.file.download', ['file' => $file, 'ext' => $file->ext]) }}">Download
                        here</a></div>
            @else
                <div class="d-sm-inline-block d-block pr-1 pl-1 border-right"><a>Don't have permission to download</a>
                </div>
            @endif
        </div>
    </div>
</div>
