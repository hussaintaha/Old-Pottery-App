<div class="Polaris-Tabs__Wrapper">
   <ul role="tablist" class="Polaris-Tabs">
      <li class="Polaris-Tabs__TabContainer">
        <a href="{{url('/dashboard')}}?shop={{$shop}}">
          <button  role="tab" type="button"
          class="Polaris-Tabs__Tab {{($page == 'dashboard' ? 'Polaris-Tabs__Tab--selected' : '')}} "
          aria-selected="true" aria-controls="all-customers-content" aria-label="All customers">
          <span class="Polaris-Tabs__Title">Dashboard</span>
        </button>
      </a>
      </li>

      <li class="Polaris-Tabs__TabContainer">
        <a href="{{url('/settings')}}?shop={{$shop}}">
          <button type="button"  class="Polaris-Tabs__Tab {{($page == 'settings' ? 'Polaris-Tabs__Tab--selected' : '')}}" aria-selected="false" aria-controls="accepts-marketing-content">
            <span class="Polaris-Tabs__Title">Settings</span>
          </button>
        </a>
        </li>
      <li class="Polaris-Tabs__TabContainer">
          <a href="{{url('/manage-locations')}}?shop={{$shop}}">
            <button  type="button"  class="Polaris-Tabs__Tab {{($page == 'manage-locatins' ? 'Polaris-Tabs__Tab--selected' : '')}}" aria-selected="false" aria-controls="repeat-customers-content">
                <span class="Polaris-Tabs__Title">
                  Locations
                </span>
              </button>
          </a>
        </li>
        @if($page == 'edit-locations')
          <li class="Polaris-Tabs__TabContainer">
            <a href="{{url('/manage-locations')}}?shop={{$shop}}">
              <button  type="button"  class="Polaris-Tabs__Tab {{($page == 'edit-locations' ? 'Polaris-Tabs__Tab--selected' : '')}}" aria-selected="false" aria-controls="repeat-customers-content">
                <span class="Polaris-Tabs__Title">
                  Update Location
                </span>
              </button>
            </a>
          </li>
        @endif
   </ul>
</div>
