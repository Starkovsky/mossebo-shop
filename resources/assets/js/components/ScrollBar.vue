<template>
    <div class="scrollbar-progress">
        <div class="scrollbar-progress__bar"></div>
    </div>
</template>

<script>
    export default {
        name: "ScrollBar",
        mounted: function () {
            window.addEventListener('scroll', function () {
                var wintop = $(window).scrollTop(),
                    docheight = $('#app').height(),
                    winheight = $(window).height();
                //console.log(wintop);
                var totalScroll = (wintop/(docheight-winheight))*100;
                //console.log("total scroll" + totalScroll);
                $(".scrollbar-progress__bar").css("width",totalScroll+"%");
            }, { passive: true })
        }
    }
</script>

<style lang="scss" scoped>

    @import "../../sass/variables/colors";

    body {
        margin-top: 0.2em;
    }

    .scrollbar-progress {
        left:0;
        width: 100%;
        height: 0.3em;
        margin-bottom: 0px;
        position: fixed;
        top: 0px;
        z-index: 99999;
        overflow: hidden;
        background-color: $color-ui;
        content: "";
        display: table;
        table-layout: fixed;
    }

    .scrollbar-progress__bar {
        width: 0%;
        float: left;
        z-index: 999999;
        height: 100%;
        max-width: 100%;
        background-color: $color-primary;
        //transition: width .2s ease;
    }
</style>
