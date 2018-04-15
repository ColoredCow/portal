<template>
    <div class="d-inline">
        <div class="btn-group applicant-round-actions" v-if="nextRound">
                <button type="button" class="btn btn-outline-success round-submit" data-status="confirmed" :data-next-round="nextRound.id">Move to {{ nextRound.name }}</button>
                <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu py-0">
                    <div class="dropdown-item" v-for="round in rounds" @click="updateNextRound(round)">{{ round.name }}</div>
                </div>
        </div>
        <div v-else class="d-inline">
            <button class="btn btn-success round-submit" data-status="confirmed">Complete</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['rounds'],
        data() {
            return {
                nextRound: this.rounds.length ? this.rounds[0] : '',
            }
        },
        methods: {
            updateNextRound: function(round) {
                this.nextRound = round;
            },
        },
    }
</script>
