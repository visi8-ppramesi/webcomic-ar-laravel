<template>
    <div class="flex text-center text-white text-5xl w-screen justify-center items-center">
        <div>
            Loading... Please wait
        </div>
    </div>
</template>

<script>
export default {
    name: 'testing',
    created(){
        document.body.insertAdjacentHTML('beforeend', this.scene)
    },
    beforeDestroy(){
        const ascene = document.getElementsByTagName('a-scene')[0]
        if(ascene !== null){
            ascene.parentNode.removeChild(ascene)
        }
        const eightWallLoading = document.getElementById('loadingContainer')
        if(eightWallLoading !== null){
            eightWallLoading.parentNode.removeChild(eightWallLoading)
        }
        const html = document.getElementsByTagName('html')[0]
        html.className = this.origHtmlClass
        window.removeEventListener('xrloaded', this.onXrLoaded)
    },
    data(){
        return {
            origHtmlClass: '',
            scene:
            `
                <a-scene
                    xrextras-gesture-detector
                    xrextras-almost-there
                    xrextras-loading
                    xrextras-runtime-error
                    renderer="colorManagement: true"
                    xrweb>
                    <a-assets>
                        <a-asset-item id="sandCastleModel" src="https://visi8-webcomic.s3.ap-southeast-1.amazonaws.com/0_1.glb"></a-asset-item>
                    </a-assets>
                    <a-camera
                        id="camera"
                        position="0 8 8"
                        raycaster="objects: .cantap"
                        cursor="fuse: false; rayOrigin: mouse;">
                    </a-camera>
                    <a-entity
                        light="
                        type: directional;
                        intensity: 0.8;
                        castShadow: true;
                        shadowMapHeight:2048;
                        shadowMapWidth:2048;
                        shadowCameraTop: 10;
                        target: #model;"
                        xrextras-attach="target: model; offset: 1 15 3;"
                        shadow>
                    </a-entity>
                    <a-light type="ambient" intensity="0.7"></a-light>
                    <a-entity
                        id="model"
                        gltf-model="#sandCastleModel"
                        class="cantap"
                        xrextras-hold-drag
                        xrextras-two-finger-rotate
                        xrextras-pinch-scale
                        scale="3 3 3"
                        shadow="receive: false">
                    </a-entity>
                </a-scene>
            `
        }
    }
}
</script>
