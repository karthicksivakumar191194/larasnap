<nav aria-label="breadcrumb">
	<ol class="breadcrumb hidden-xs" style="background-color: transparent;">
	@php
			$dashboard_url = route(config('larasnap.general.dashboard_route_name'));
			//replace dashboard url to 'empty string'
			//explode by '/'
			//pass to 'array_filter' to remove the empty array value(here index-0)
			$segments = array_filter(explode('/', str_replace($dashboard_url , '', Request::url())));
			$url = $dashboard_url;
	@endphp
	@if(count($segments) == 0)
			<li class="breadcrumb-item active">Dashboard</li>
	@else
			<li class="breadcrumb-item active">
				<a href="{{ $url }}">Dashboard</a>
			</li>
			@foreach ($segments as $segment)
				@php
					$url .= '/'.$segment;
				@endphp
				@if ($loop->first && !$loop->last)
					<li class="breadcrumb-item">
						<a href="{{ $url }}">{{ ucfirst($segment) }}</a>
					</li>
				@else
					<li class="breadcrumb-item">{{ ucfirst($segment) }}</li>
				@endif
			@endforeach
	@endif
	</ol>
</nav>