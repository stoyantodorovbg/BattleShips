<template>
    <div class="container battle-ships">
        <div v-for="row in grid.battle_ships_grid" class="row-cells">
            <div v-for="cell in row" class="cell">
                <span v-if="! cell.is_hit">.</span>
                <span v-if="cell.is_hit && cell.is_empty">.</span>
                <span v-if="cell.is_hit && ! cell.is_empty">.</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['grid'],
    }
</script>

<style lang="scss">
    .battle-ships {
        .row-cells {
            display: flex;

            .cell {
                width: 2.5rem;
                height: 2.5rem;
                border: 0.01rem solid green;
                margin: 0.1rem;
                display: flex;
                align-items: center;
                justify-content: center;

                span {
                    padding-bottom: 4px;
                }
            }
        }
    }
</style>
