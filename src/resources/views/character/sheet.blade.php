@extends('web::character.layouts.view', ['viewname' => 'sheet'])

@section('title', trans_choice('web::seat.character', 1) . ' ' . trans('web::seat.sheet'))
@section('page_header', trans_choice('web::seat.character', 1) . ' ' . trans('web::seat.sheet'))

@section('character_content')

  <div class="row">

    <div class="col-md-6">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ trans('web::seat.skills_summary') }}</h3>
        </div>
        <div class="panel-body">

          <dl>

            <dt>{{ trans('web::seat.curr_training') }}</dt>
            <dd>
              @if($skill_queue->count() > 0)
                {{ $skill_queue->first()->type->typeName }} to level <b>{{ $skill_queue->first()->finished_level }}</b>
              @else
                {{ trans('web::seat.no_skill_training') }}
              @endif
            </dd>

            <dt>{{ trans('web::seat.skill_training_end') }}</dt>
            <dd>
              @if($skill_queue->count() > 0)
                {{ human_diff(carbon($skill_queue->first()->finish_date)->toDateString()) }} on {{ carbon($skill_queue->first()->finish_date)->toDateString() }} at {{ carbon($skill_queue->first()->finish_date)->toTimeString() }}
              @else
                {{ trans('web::seat.no_skill_training') }}
              @endif
            </dd>

            <dt>{{ trans('web::seat.skill_queue') }}</dt>
            <dd>
              @if($skill_queue && count($skill_queue) > 0)
                <ol>

                  @foreach($skill_queue->slice(2)->all() as $skill)

                    <li>
                      <span class="col-md-9" data-toggle="tooltip" title=""
                            @if($skill->endTime != '0000-00-00 00:00:00')
                            data-original-title="Ends {{ human_diff(carbon($skill->finish_date)->toDateString()) }} on {{ carbon($skill->finish_date)->toDateString() }} at {{ carbon($skill->finish_date)->toTimeString() }}"
                              @endif>{{ $skill->type->typeName }}</span>
                      <span class="col-md-3">
                        @for($i = 1; $i <= $skill->finished_level; $i++)
                        @if($i == $skill->finished_level)
                        <span class="fa fa-star text-green"></span>
                        @else
                        <span class="fa fa-star"></span>
                        @endif
                        @endfor
                      </span>
                    </li>

                  @endforeach

                </ol>
              @else
                {{ trans('web::seat.empty_skill_queue') }}
              @endif
            </dd>

          </dl>

        </div>
        <div class="panel-footer">
          {{ count($skill_queue) }} {{ trans_choice('web::seat.skill', count($skill_queue)) }}
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ trans('web::seat.jump_fatigue') }} &amp; {{ trans_choice('web::seat.jump_clones', 0) }}</h3>
        </div>
        <div class="panel-body">

          <dl>
            <dt>{{ trans('web::seat.jump_fatigue') }}</dt>
            <dd>

              @if(!is_null($fatigue) && carbon($fatigue->jump_fatigue_expire_date)->gt(carbon(null)))
                {{ $fatigue->jump_fatigue_expire_date }}
                <span class="pull-right">Ends approx {{ human_diff($fatigue->jump_fatigue_expire_date) }}</span>
              @else
                None
              @endif

            </dd>

            <dt>{{ trans('web::seat.jump_act_timer') }}</dt>
            <dd>
              @if(!is_null($last_jump) && carbon($last_jump->last_clone_jump_date)->gt(carbon(null)))
                {{ $last_jump->last_clone_jump_date }}
                <span class="pull-right">Ends approx {{ human_diff($last_jump->last_clone_jump_date) }}</span>
              @else
                {{ trans('web::seat.none') }}
              @endif
            </dd>

            <dt>{{ trans_choice('web::seat.jump_clones', 0) }}</dt>
            <dd>

              @if(count($jump_clones) > 0)

                <ul>

                  @foreach($jump_clones as $clone)
                    @if(!is_null($clone->location))
                    <li>Located at <b>{{ $clone->location->stationName }}</b></li>
                    @else
                    <li>Location is unknown</li>
                    @endif
                  @endforeach

                </ul>

              @else
                {{ trans('web::seat.no_jump_clones') }}
              @endif

            </dd>

          </dl>

        </div>
        <div class="panel-footer">
          {{ count($jump_clones) }} {{ trans_choice('web::seat.jump_clones', count($jump_clones)) }}
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ trans_choice('web::seat.implants', 0) }}</h3>
        </div>
        <div class="panel-body">

          @if(count($implants) > 0)

            <ul>

              @foreach($implants as $implant)
                <li>{{ $implant->type->typeName }}</li>
              @endforeach

            </ul>

          @else
            {{ trans('web::seat.no_implants') }}
          @endif

        </div>
        <div class="panel-footer">
          {{ count($implants) }} {{ trans_choice('web::seat.implants', count($implants)) }}
        </div>
      </div>

    </div>

    <div class="col-md-6">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ trans('web::seat.employment_history') }}</h3>
        </div>
        <div class="panel-body">

          @if(count($employment) > 0)
          <ul class="list-unstyled">

            @foreach($employment as $history)

              <li>
                {!! img('corporation', $history->corporation_id, 32, ['class' => 'img-circle eve-icon small-icon']) !!}
                <b><span rel="id-to-name">{{ $history->corporation_id }}</span></b> on {{ carbon($history->start_date)->toDateString() }}
                <span class="pull-right">
                 {{ human_diff($history->start_date) }}
                </span>
              </li>

            @endforeach

          </ul>
          @else
            {{ trans('web::seat.no_employment_information') }}
          @endif

        </div>
        <div class="panel-footer">
          {{ count($employment) }} {{ trans_choice('web::seat.corporation', count($employment)) }}
        </div>
      </div>

    </div>

    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ trans_choice('web::seat.corporation_titles', 0) }}</h3>
        </div>
        <div class="panel-body">
          @if(count($titles) > 0)
          <ul class="list-unstyled">
            @foreach($titles as $title)
              <li>{!! clean_ccp_html($title->name) !!}</li>
            @endforeach
          </ul>
          @else
            {{ trans('no_corporation_titles') }}
          @endif
        </div>
        <div class="panel-footer">
          {{ count($titles) }} {{ trans_choice('web::seat.corporation_titles', count($titles)) }}
        </div>
      </div>
    </div>

  </div>

@stop

@push('javascript')
@include('web::includes.javascript.id-to-name')
@endpush
