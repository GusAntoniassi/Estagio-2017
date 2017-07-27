<?php
return [
    'nextActive' 		=> '<li class="next waves-effect"><a rel="next" href="{{url}}"><i class="material-icons">chevron_right</i></a></li>',
	'nextDisabled' 		=> '<li class="next disabled"><a href="" onclick="return false;"><i class="material-icons">chevron_right</i></a></li>',
	'prevActive' 		=> '<li class="prev waves-effect"><a rel="prev" href="{{url}}"><i class="material-icons">chevron_left</i></a></li>',
	'prevDisabled' 		=> '<li class="prev disabled"><a href="" onclick="return false;"><i class="material-icons">chevron_left</i></a></li>',
	'first' 			=> '<li class="first waves-effect"><a rel="first" href="{{url}}"><i class="material-icons">first_page</i></a></li>',
	'last' 				=> '<li class="last waves-effect"><a rel="last" href="{{url}}"><i class="material-icons">last_page</i></a></li>',
	'counterRange' 		=> 'Página {{start}} - {{end}} de {{count}}, exibindo {{current}} registro(s) de um total de {{count}}',
	'counterPages' 		=> 'Página {{page}} de {{pages}}, exibindo {{current}} registro(s) de um total de {{count}}',
	'number' 			=> '<li class="waves-effect"><a class="number" href="{{url}}">{{text}}</a></li>',
	'current' 			=> '<li class="active"><a class="number" href="" onclick="return false;">{{text}}</a></li>',
	'ellipsis' 			=> '<li class="ellipsis">...</li>',
	'sort' 				=> '<a href="{{url}}">{{text}}</a>',
	'sortAsc' 			=> '<a class="asc" href="{{url}}">{{text}}</a>',
	'sortDesc' 			=> '<a class="desc" href="{{url}}">{{text}}</a>',
	'sortAscLocked'		=> '<a class="asc locked" href="{{url}}">{{text}}</a>',
	'sortDescLocked' 		=> '<a class="desc locked" href="{{url}}">{{text}}</a>',
];
