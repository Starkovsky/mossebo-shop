<template>
    <div>
        <a
            class="filter-name"
            data-toggle="collapse"
            :href="'#filerCollapse'+filterID"
            role="button"
            aria-expanded="true"
            :aria-controls="'filerCollapse'+filterID"
        >
            {{ filter.name }}
            <svg class="symbol-icon symbol-keyboard-down">
                <use xlink:href="/assets/images/icons.svg#symbol-keyboard-down"></use>
            </svg>
        </a>
        <div class="filter-desc collapse multi-collapse show" :id="'filerCollapse'+filterID">
            <div
                v-for="value in filter.values"
            >
                <label class="filter-label">
                    {{ value }}
                    <input type="checkbox" :value="value">
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CatalogFilter",
        props: [
            'filter',
            'filterID',
        ],
    }
</script>

<style lang="scss" scoped>

    @import "../../../sass/variables/colors";

    .filter-name {
        display: block;
        position: relative;
        padding: 20px;
        color: $color-text-primary;
        &:hover {
            text-decoration: none;
            .symbol-icon {
                fill: $color-text-primary;
            }
        }
        .symbol-icon {
            float: right;
        }
        &[aria-expanded="false"] {
            .symbol-icon {
                transform: rotate(0deg);
            }
        }
        &[aria-expanded="true"] {
            .symbol-icon {
                transform: rotate(180deg);
            }
        }
    }
    .filter-desc {
        padding: 0 20px 20px;
    }
    .filter-label {
        display: block;
        position: relative;
        color: $color-text-primary;
        font-size: 13px;
        margin-bottom: 12px;
        padding-left: 35px;
        cursor: pointer;
        user-select: none;
        input {
            display: none;
            &:checked ~ .checkmark {
                background-color: $color-primary !important;
                border: 2px solid $color-primary !important;
                &:after {
                    display: block;
                }
            }
        }
        &:hover input ~ .checkmark {
            background-color: $color-border;
        }
        .checkmark:after {
            left: 5px;
            top: 2px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            transform: rotate(45deg);
        }
    }
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: $color-ui;
        border: 2px solid $color-border;
        border-radius: 2px;
        box-sizing: border-box;
        &:after {
            content: "";
            position: absolute;
            display: none;
        }
    }

</style>
