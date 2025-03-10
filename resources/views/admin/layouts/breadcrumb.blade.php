@if (!empty($breadcrumbs))
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{ trim($__env->yieldContent('title')) }}</h2>
        <ol class="breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb['url'])
                    <li>
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a>
                    </li>
                @else
                    <li class="active"><strong>{{ $breadcrumb['name'] }}</strong></li>
                @endif
            @endforeach
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
@endif