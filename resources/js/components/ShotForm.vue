<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-6 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">ROW</span>
                </div>
                <input type="text"
                       v-model="row_data"
                       maxlength="1"
                       class="form-control"
                       placeholder="Enter a Character"
                >
            </div>
            <div class="col-6 input-group mb-3">

                <input type="number"
                       v-model="col_data"
                       maxlength="1"
                       min="1"
                       :max="getColsCount()"
                       class="form-control"
                       placeholder="Enter a Number"
                >
                <div class="input-group-prepend">
                    <span class="input-group-text">COL</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 input-group mb-3">
                <button @click="submitShot()"
                        type="button"
                        class="btn btn-primary w-100 font-weight-bolder"
                >
                    SHOT
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'shot-form',

        data() {
            return {
                row_data: '',
                col_data: '',
            };
        },

        methods: {
            submitShot() {
                let component = this;
                axios.post('/shot', this.getData())
                    .then(response => {
                        component.$parent.$data.gridData = response.data.grid
                    }).catch(function () {
                        console.log('Something went wrong.');
                });
            },

            getData() {
                return {
                    row: this.convertChar(),
                    col: this.col_data,
                }
            },

            getColsCount() {
                return Object.keys(this.$parent.gridData[1]).length;
            },

            convertChar() {
                let component = this;
                return this.$parent.$data.alphabet.findIndex(function (char) {
                    return char === component.row_data;
                }) + 1;
            },
        }
    }
</script>
