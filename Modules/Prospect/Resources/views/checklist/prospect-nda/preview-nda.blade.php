<div class="card border-dark inline-card inline-resume" id="sliding_resume" v-cloak 
style="right: 0;left: inherit;"
>
    <div class="card-header bg-warning">
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <b><a class="nav-link py-0" :href="'/legaldocument/nda/template/'+ template" target="_blank">
                    <i class="fa fa-edit" aria-hidden="true">
                        </i>&nbsp;Edit this template</a></b>
            </li>

            <li class="nav-item">
                <b>
                    <a class="nav-link py-0" :href="nDAPriviewResume" target="_blank">
                        <i class="fa fa-external-link" aria-hidden="true"></i> Open in a New Tab
                    </a>
                </b>
            </li>
            <li class="nav-item">
                <b><span class="c-pointer text-primary" @click="toggleNDAPreview()">Close</span></b>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <iframe :src="nDAPriviewResume"></iframe>
    </div>
</div>