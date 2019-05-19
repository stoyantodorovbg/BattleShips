<template>
    <div class="container shot-form">
        <div class="row mt-5">
            <div class="col-12 input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">ROW</span>
                </div>
                <input type="text"
                       v-model="coordData"
                       :disabled="gameFinish ? true : false"
                       maxlength="3"
                       class="form-control text-center"
                       placeholder="Enter cell coordinates"
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
                        :disabled="disableSubmit ? true : false"
                        class="btn btn-primary w-100 font-weight-bolder"
                >
                    SHOOT
                </button>
            </div>
        </div>
        <div v-if="wrongInput" class="row font-weight-bolder wrong-input text-uppercase">
            <div class="col-12 text-center">
                {{ wrongInput }}
            </div>
        </div>
        <div v-if="success"  class="row font-weight-bolder success-message">
            <div class="col-12 text-center">
                Well done! You completed the game in {{ shotsCount }} shots
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'shot-form',

        data() {
            return {
                coordData: '',
                rowData: '',
                colData: '',
                gameFinish: false,
                disableSubmit: this.gameFinish,
                wrongInput: '',
                rowsCount: this.getRowsCount(),
                colsCount: this.getColsCount(),
                shotsCount: 0,
                success: false,
            };
        },

        watch: {
            coordData: function (value) {
                this.disableSubmit = false;
                this.wrongInput = '';

                this.rowData = value[0];
                if(value.hasOwnProperty(1)) {
                    this.colData = value[1];
                } else {
                    this.wrongInput = 'Please enter a col!';
                }

                if(value.hasOwnProperty(2)) {
                    this.colData += value[2];
                }

                if(! this.checkRowData(this.rowData)) {
                    this.disableSubmit = true;
                    this.wrongInput = 'wrong input!';
                }

                if(! this.checkColData(this.colData)) {
                    this.disableSubmit = true;
                    this.wrongInput = 'wrong input!';
                }
            },
        },

        methods: {
            submitShot() {
                let dataCell = this.getData();

                if(dataCell.row && dataCell.col) {
                    let component = this;

                    axios.post('/shot', dataCell)
                        .then(response => {
                            if(response.data.already_hit_cell) {
                                component.wrongInput = 'This cell has already been hit.'
                            } else {
                                component.updateGridData(response, dataCell);
                            }
                        }).catch(function () {
                        console.log('Something went wrong.');
                    });
                } else {
                    this.disableSubmit = true;
                    this.wrongInput = 'wrong input!';
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

            updateGridData(response, dataCell)
            {
                this.$parent.$data.gridData[dataCell.row][dataCell.col]['is_hit'] = true;

                if(response.data.empty_cell) {
                    this.$parent.$data.gridData[dataCell.row][dataCell.col]['is_empty'] = true;
                } else {
                    this.$parent.$data.gridData[dataCell.row][dataCell.col]['is_empty'] = false;
                }

                if(response.data.shot_count) {
                    this.gameFinish = true,
                    this.shotsCount = response.data.shot_count;
                    this.success = true;
                }
            }
        }
    }
</script>

<style lang="scss">
    .shot-form {
        .wrong-input {
            color: red;
        }

        .success-message {
            color: green;
            font-size: 2em;
        }
    }
</style>
