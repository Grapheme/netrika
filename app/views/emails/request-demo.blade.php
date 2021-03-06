<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
</head>
<body>
	<div>
		<p>
            Запрос на демонстрацию решения &laquo;{{ $solution->name }}&raquo;<br/>

            @if (isset($components) && is_array($components) && count($components))
            Выбранные компоненты:
                <ul>
                @foreach ($components as $component)
                    <li>{{ $component }}</li>
                @endforeach
                </ul>
            @endif

            @if ($name)
            Имя: {{ $name }}<br/>
            @endif

            @if ($org)
            Организация: {{ $org }}<br/>
            @endif

            @if ($role)
            Должность: {{ $role }}<br/>
            @endif

            @if ($email)
            E-mail: {{ $email }}<br/>
            @endif

            @if ($phone)
            Телефон: {{ $phone }}<br/>
            @endif

            @if ($comment)
            Комментарий: {{ $comment }}<br/>
            @endif

		</p>
	</div>
</body>
</html>