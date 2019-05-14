<template>
    <div class="container battle-ships">
        <div class="row-cells">
            <div class="cell cell-hidden"></div>
            <div v-for="(row, index) in gridData"
                 :key="index"
                 class="text-uppercase cell"
            >
                {{ index }}
            </div>
        </div>
        <div v-for="(row, index) in gridData"
             :key="index" class="row-cells"
        >
            <div class="text-uppercase cell">
                {{ alphabet[index - 1] }}
            </div>
            <div v-for="(cell, index) in row"
                 :key="index" class="cell"
            >
                <span v-if="! cell.is_hit">.</span>
                <span v-if="cell.is_hit && cell.is_empty" class="empty">-</span>
                <span v-if="cell.is_hit && ! cell.is_empty">X</span>
            </div>
        </div>

        <shot-form></shot-form>
    </div>
</template>

<script>
    import ShotForm from './ShotForm';

    export default {
        name: 'battle-ships',

        components: {ShotForm},

        props: ['grid'],

        data() {
            return {
                alphabet: this.getAlphabet(),
                gridData: this.grid.battle_ships_grid,
            }
        },

        methods: {
            getAlphabet() {
                return [...Array(26).keys()].map(i => String.fromCharCode(i + 97));
            }
        }
    }
</script>

<style lang="scss">
    .battle-ships {

        .row-cells {
            display: flex;
            justify-content: center;

            .cell {
                width: 2.5rem;
                height: 2.5rem;
                border: 0.01rem solid deepskyblue;
                margin: 0.1rem;
                display: flex;
                align-items: center;
                justify-content: center;

                span {
                    padding-bottom: 16px;
                    font-size: 2rem;
                }

                .empty {
                    padding-bottom: 4px;
                }
            }

            .cell-hidden {
                visibility: hidden;
            }
        }
    }
</style>
