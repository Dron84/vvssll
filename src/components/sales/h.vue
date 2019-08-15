<template>
    <div>
        <h4 class="header">{{header}}</h4>
        <div id="Search_Input">
            <svg class="Rectangle_567">
                <rect id="Rectangle_567" rx="4" ry="4" x="0" y="0" width="570" height="45">
                </rect>
            </svg>
            <input :placeholder="placeholder" @keyup="searchEnter()" v-model="searchText">
            <svg class="Search_Icon" viewBox="0 0 16 16">
                <path id="Search_Icon" d="M 12.69999980926514 11.22981357574463 C 13.59999942779541 10.03726673126221 14.09999942779541 8.645962715148926 14.09999942779541 7.055900573730469 C 14.10000038146973 3.180124044418335 11 0 7.099999904632568 0 C 3.199999809265137 0 0 3.180124044418335 0 7.055900096893311 C 0 10.93167686462402 3.200000047683716 14.11180019378662 7.099999904632568 14.11180019378662 C 8.699999809265137 14.11180019378662 10.19999980926514 13.61490631103516 11.29999923706055 12.72049617767334 L 14.29999923706055 15.70186328887939 C 14.49999904632568 15.90062046051025 14.79999923706055 16 14.99999904632568 16 C 15.19999885559082 16 15.49999904632568 15.90062046051025 15.69999885559082 15.70186328887939 C 16.09999847412109 15.30434799194336 16.09999847412109 14.70807456970215 15.69999885559082 14.31055927276611 L 12.69999980926514 11.22981357574463 Z M 7.099999904632568 12.0248441696167 C 4.300000190734863 12.0248441696167 2 9.838508605957031 2 7.055900096893311 C 2 4.273292064666748 4.300000190734863 1.987577557563782 7.099999904632568 1.987577557563782 C 9.899999618530273 1.987577557563782 12.19999980926514 4.273292064666748 12.19999980926514 7.055900096893311 C 12.19999980926514 9.838508605957031 9.899999618530273 12.0248441696167 7.099999904632568 12.0248441696167 Z">
                </path>
            </svg>
        </div>
    </div>
</template>

<script>
    export default {
        name: "h",
        data(){
            return{
                searchText: '',
            }
        },
        props:{
            header: {
                type: String,
                default: 'Some Text'
            },
            placeholder: {
                type: String,
                default: 'Enter text'
            }
        },
        methods:{
            searchEnter(){
                this.$emit('searchInfo',this.searchText)
            }
        }
    }
</script>

<style scoped>
    .header {
        display: inline-flex;
        top: 15px;
        position: relative;
    }
    #Search_Input {
        position: relative;
        width: 570px;
        height: 45px;
        overflow: visible;
        display: inline-flex;
        float: right;
    }
    #Search_Input input{
        overflow: visible;
        border: none;
        height: 40px;
        position: absolute;
        top: 3px;
        left: 60px;
        width: 505px;
    }
    #Rectangle_567 {
        fill: rgba(255,255,255,1);
        stroke: rgb(112, 112, 112);
        stroke-width: 1px;
        stroke-linejoin: miter;
        stroke-linecap: butt;
        stroke-miterlimit: 4;
        shape-rendering: auto;
    }
    .Rectangle_567 {
        position: absolute;
        overflow: visible;
        width: 570px;
        height: 45px;
        left: 0px;
        top: 0px;
    }
    #Search_Icon {
        fill: rgba(188,188,203,1);
        stroke: rgb(112, 112, 112);
        stroke-width: 1px;
        stroke-linejoin: miter;
        stroke-linecap: butt;
        stroke-miterlimit: 4;
        shape-rendering: auto;
    }
    .Search_Icon {
        transform: matrix(1,0,0,1,0,0);
        overflow: visible;
        position: absolute;
        top: 15px;
        left: 32px;
        width: 17px;
        height: 17px;
    }
</style>