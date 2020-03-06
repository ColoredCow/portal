<div>
    <project-billing-info-component 
        :states="{{ $states }}" 
        :project="{{ $project ?? json_encode([])  }}"
        :billinginfo="{{ optional($project)->billingInfo  }}" 
        
        />
</div>