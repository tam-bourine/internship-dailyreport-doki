export const state = () => ({
    draft: ''
});

//mutations to change value in state.
export const mutations = {

    //push word to words list
    setDraft(state, payload) {

        state.draft = payload;

    },



}

//getters to get value from store.
export const getters = {

    getDraft(state) {
        return state.draft;
    }

}


export const actions = {

}
