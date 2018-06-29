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


</style>
