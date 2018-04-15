<template>
        <div class="btn-group applicant-round-actions">
            <button type="button" class="btn btn-outline-success round-submit" data-status="confirmed">Move to {{ nextRound }}</button>
            <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu py-0">
                <div class="dropdown-item" v-for="round in rounds" @click="updateNextRound(round.name)">{{ round.name }}</div>
            </div>
        </div>
</template>

<script>
    export default {
        props: ['rounds'],
        data() {
            return {
                nextRound: this.rounds ? this.rounds[0].name : '',
            }
        },
        methods: {
            updateNextRound: function(roundName) {
                this.nextRound = roundName;
            },
        },
        mounted() {
        },
    }
</script>
