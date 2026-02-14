import {
    getProductions,filterProductions, getProductionColumns, firstProductionRecord, lastProductionRecord,
} from '../../../helpers/axios';
export default {
    state: {
        recordList:[],
        columnList: [],
        firstRecord: [],
        lastRecord: [],
        busy: true,
        isFiltered: false,
    },
    mutations: {
        /**
         * Production Mutations
         * */
        removeProduction: (state, payload) => {
            let item = state.recordList.find(obj => obj.production_id == payload);
            // state.quote.recordList.splice(item,1);
            state.recordList = state.recordList.filter(obj => obj.production_id != payload)
        },
        setProductionList: (state, payload) => {
            state.recordList = payload;
            state.firstRecord = payload[0];
            state.lastRecord = payload[payload.length - 1];
            state.busy = false;
        },
        setFirstProductionRecord: (state, payload) => {
            state.firstRecord = payload;
        },
        setLastProductionRecord: (state, payload) => {
            state.lastRecord = payload;
        },
        updateProductionList: (state, payload) =>{
            state.recordList.splice(payload.index,1,payload.row)
        },
    },
    actions: {
        /**
         * Production Actions
         * */
        getProductionsInfo: context => {
            getProductions(function (response) {
                context.commit('setProductionList', response.data);
            }, (error)=>{
                console.error(error)
            });
        },
        getProductionColumnList: context => {
            getProductionColumns(function (response) {
                let data = {type:'production',data:response.data}
                context.commit('setColumns', data);
            }, (error)=>{
                console.error(error)
            });
        },
        getFilteredProductions: (context, formData) => {
            filterProductions(formData, (response) => {
                context.commit('setProductionList', response.data);
            }, error => {
                console.error(error)
            })
        },
        removeProductionFromList: (context, id) =>{
            context.commit('removeProduction', id);
            context.commit('setFirstAndLastRecord');
        },
        getFirstProduction: context => {
            firstProductionRecord( response => {
                context.commit('setFirstProductionRecord', response.data);
            })
        },
        getLastProduction: context => {
            lastProductionRecord( response => {
                context.commit('setLastProductionRecord', response.data);
            })
        },
    },
    getters: {},
}
