<template id="signature-pad-template">
    <div id="signature-pad" class="signature-pad">
        <div class="signature-pad__body">
            <canvas ref="canvas" width="350" height="150"></canvas>
            <!--<canvas ref="canvas" v-on:mouseup="saveSignature()" width="350" height="150"></canvas>-->
        </div>
    </div>
</template>

<script>
    import SignaturePad from 'signature_pad'
    export default {
        name: 'Signature',
        props: ['signatureFor'],
        template: '#signature-pad-template',
        data: () => ({
            pad: null,
            signature: null
        }),
        mounted() {
            this.pad = new SignaturePad(this.$refs.canvas)
            this.pad.name = this.signatureFor
        },
        methods: {
            saveSignature: function() {
                this.signature = this.pad.toDataURL()
                this.$emit('signed', this.signature)
            },
            clearSignature: function() {
                this.pad.clear()
                this.signature = null
                this.$emit('signed', null)
            },
            resizeCanvas: function() {
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                this.$refs.canvas.width = this.$refs.canvas.offsetWidth * ratio
                this.$refs.canvas.height = this.$refs.canvas.offsetHeight * ratio
                this.$refs.canvas.getContext('2d').scale(ratio, ratio)
            }
        }
    }
</script>

<style scoped>

</style>