<template>
    <div class="tab-pane fade" v-bind:class="{ 'show active': active == 'flux' }" id="v-pills-flux" role="tabpanel" aria-labelledby="v-pills-flux-tab">
        <div class="row">
            <div class="col-12">
                <el-tabs type="border-card">
                    <el-tab-pane label="Objetivos">
                        <comp-goals :customer="customer" :customer_area="customer_area" />
                    </el-tab-pane>
                    <el-tab-pane label="Fluxo de Caixa">
                        <cash-planing :customer="customer" />
                    </el-tab-pane>
                    <el-tab-pane label="Reuniões">
                        <comp-meetings :customer="customer" :customer_area="customer_area" />
                    </el-tab-pane>
                </el-tabs>
            </div>
        </div>
    </div>
</template>
<script>
import CashPlaning from './cash-planing'
export default {
    props: ['active', 'customer', 'customer_area'],
    data() {
        return {
            loading: false,
            months: this.$getMoths(),
        }
    },
    components: {
        'comp-goals': require('./-goals.vue').default,
        'cash-planing': require('./cash-planing').default,
        'comp-meetings': require('./-meetings').default,
    },
}
</script>