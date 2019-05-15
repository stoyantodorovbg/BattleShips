<template>
    <div class="container shot-form">
        <div class="row mt-5">
            <div class="col-6 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">ROW</span>
                </div>
                <input type="text"
                       v-model="rowData"
                       maxlength="1"
                       class="form-control"
                       placeholder="Enter a Character"
                >
            </div>
            <div class="col-6 input-group mb-3">

                <input type="number"
                       v-model="colData"
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
                        :disabled="wrongInput ? true : false"
                        class="btn btn-primary w-100 font-weight-bolder"
                >
                    SHOT
                </button>
            </div>
        </div>
        <div v-if="wrongInput" class="row font-weight-bolder wrong-input">
            <div class="col-12 text-center">
                WRONG INPUT!
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'shot-form',

        data() {
            return {
                rowData: '',
                colData: '',
                wrongInput: false,
                rowsCount: this.getRowsCount(),
                colsCount: this.getColsCount(),
            };
        },

        watch: {
            rowData: function (value) {
                this.wrongInput = false;

                if(! this.checkRowData(value)) {
                    this.wrongInput = true;
                }
            },
            colData: function (value) {
                this.wrongInput = false;

                if(! this.checkColData(value)) {
                    this.wrongInput = true;
                }
            }
        },

        methods: {
            submitShot() {
                let data = this.getData();

                if(data.row && data.col) {
                    let component = this;

                    axios.post('/shot', data)
                        .then(response => {
                            component.$parent.$data.gridData = response.data.grid
                        }).catch(function () {
                        console.log('Something went wrong.');
                    });
                } else {
                    this.wrongInput = true;
                }
            },

            getData() {
                return {
                    row: this.convertChar(),
                    col: this.colData,
                }
            },

            getColsCount() {
                return Object.keys(this.$parent.gridData[1]).length;
            },

            getRowsCount() {
                return Object.keys(this.$parent.$data.gridData).length;
            },

            convertChar() {
                let component = this;
                return this.$parent.$data.alphabet.findIndex(function (char) {
                    return char === component.rowData.toLowerCase();
                }) + 1;
            },

            checkRowData(value) {
                let index = this.$parent.$data.alphabet.findIndex(function (element) {
                    return element === value.toLowerCase();
                });

                if(index <= this.rowsCount && value.match(/[A-Za-z]/)) {
                    return true;
                }

                return false;
            },

            checkColData(value) {
                if(value <= this.colsCount) {
                    return true;
                }

                return false;
            },
        }
    }
</script>

<style lang="scss">
    .shot-form {
        .wrong-input {
            color: red;
        }
    }
</style>
