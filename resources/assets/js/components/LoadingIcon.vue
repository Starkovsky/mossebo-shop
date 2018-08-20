<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 100 100"
        enable-background="new 0 0 0 0"
        xml:space="preserve"
    >
        <circle stroke="none" cx="12%" cy="50%" r="12%">
            <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1"/>
        </circle>

        <circle stroke="none" cx="50%" cy="50%" r="12%">
            <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.2"/>
        </circle>

        <circle stroke="none" cx="88%" cy="50%" r="12%">
            <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.3"/>
        </circle>
    </svg>
</template>

<script>
    export default {
        name: 'loading-icon',
    }
</script>
