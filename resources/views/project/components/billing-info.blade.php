<div>
    <project-billing-info-component 
        :states="{{ $states }}" 
        :project="{{ $project  ?? json_encode([])  }}"
        :billinginfo="{{ isset($project) ? optional($project)->billingInfo : json_encode([])  }}" 
        />
</div>