<div style="padding-bottom: 15px;">

  <ul class="nav nav-pills">
    <li role="presentation" class="@if ($sub_viewname == 'summary') active @endif">
      <a href="{{ route('character.view.intel.summary', $summary->characterID) }}">
        Summary
      </a>
    </li>
    <li role="presentation" class="@if ($sub_viewname == 'standings') active @endif">
      <a href="{{ route('character.view.intel.standingscomparison', $summary->characterID) }}">
        Standings Compare
      </a>
    </li>
    <li role="presentation" class="@if ($sub_viewname == 'note') active @endif">
      <a href="{{ route('character.view.intel.notes', $summary->characterID) }}">
        Notes
      </a>
    </li>
  </ul>

</div>
