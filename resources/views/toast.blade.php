<div id="toast_container"></div>
@section('js_scripts')
    <script>
        new Vue({
            el: "#toast_container",
            data() {
                return {
                    message: "{{ $message ?? '' }}",
                    type: "{{ $type ?? 'success' }}",
                };
            },
            mounted() {
                if (this.message) {
                    switch (this.type) {
                        case 'warning':
                        case 'error':
                        case 'info':
                        case 'success':
                            this.$toast(this.message, {
                                type: this.type,
                            });
                            break;

                        default:
                            this.$toast(this.message, {
                                type: 'success',
                            });
                            break;
                    }
                }
            }
        });
    </script>
@endsection
