@extends('web::layouts.grids.3-9')

@section('title', trans('web::seat.user_management'))
@section('page_header', trans('web::seat.user_management'))

@section('left')

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">{{ trans('web::seat.quick_add_user') }}</h3>
    </div>
    <div class="panel-body">

      <form role="form" action="{{ route('configuration.access.users.add') }}" method="post">
        {{ csrf_field() }}

        <div class="box-body">

          <div class="form-group">
            <label for="username">{{ trans_choice('web::seat.username', 1) }}</label>
            <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}"
                   placeholder="Username">
          </div>

          <div class="form-group">
            <label for="email">{{ trans_choice('web::seat.email', 1) }}</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}"
                   placeholder="Email">
          </div>

          <div class="form-group">
            <label for="password">{{ trans_choice('web::seat.password', 1) }}</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
          </div>

          <div class="form-group">
            <label for="password_confirm">{{ trans('web::seat.password_again') }}</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                   placeholder="Password">
          </div>

        </div><!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary pull-right">
            {{ trans_choice('web::seat.add_user', 1) }}
          </button>
        </div>
      </form>

    </div>
  </div>

@stop

@section('right')

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">
        {{ trans('web::seat.current_users') }}
      </h3>
    </div>
    <div class="panel-body">

      <table class="table table-hover table-condensed">
        <tbody>
        <tr>
          <th>{{ trans_choice('web::seat.name', 1) }}</th>
          <th>{{ trans('web::seat.email') }}</th>
          <th>{{ trans_choice('web::seat.status', 1) }}</th>
          <th>{{ trans('web::seat.last_login') }}</th>
          <th>{{ trans('web::seat.from') }}</th>
          <th>{{ trans_choice('web::seat.key', 2) }}</th>
          <th>{{ trans_choice('web::seat.role', 2) }}</th>
          <th></th>
        </tr>

        @foreach($users as $user)

          <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              @if(setting('require_activation', true) == 'yes')
                <span class="label label-{{ $user->active == 1 ? 'success' : 'warning' }}">
                {{ $user->active == 1 ? 'Active' : 'Inactive' }}
              </span>
              @endif
              @if(!is_null($user->eve_id))
                <span class="label label-info">Sso</span>
              @else
                <span class="label label-primary">Standard</span>
              @endif
            </td>
            <td>
            <span data-toggle="tooltip" title="" data-original-title="{{ $user->last_login }}">
              {{ human_diff($user->last_login) }}
            </span>
            </td>
            <td>{{ $user->last_login_source }}</td>
            <td>{{ count($user->keys) }}</td>
            <td>{{ count($user->roles) }}</td>
            <td>
              <div class="btn-group">
                <a href="{{ route('configuration.users.edit', ['user_id' => $user->id]) }}" type="button"
                   class="btn btn-warning btn-xs">
                  {{ trans('web::seat.edit') }}
                </a>
              </div>

              @if(auth()->user()->id != $user->id)
                <div class="btn-group">
                  <a href="{{ route('configuration.users.delete', ['user_id' => $user->id]) }}" type="button"
                     class="btn btn-danger btn-xs confirmlink">
                    {{ trans('web::seat.delete') }}
                  </a>
                  <a href="{{ route('configuration.users.impersonate', ['user_id' => $user->id]) }}" type="button"
                     class="btn btn-success btn-xs">
                    {{ trans('web::seat.impersonate') }}
                  </a>
                </div>
              @else
                <em class="text-danger">(This is you!)</em>
              @endif
            </td>
          </tr>

        @endforeach

        </tbody>
      </table>

    </div>
    <div class="panel-footer">
      <b>{{ count($users) }}</b> {{ trans_choice('web::seat.user', count($users)) }}
    </div>

  </div>

@stop
