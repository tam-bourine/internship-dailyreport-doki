export const state = () => ({
    draft: "",
    draftId: undefined,

});

export const mutations = {

    setDraft(state, payload) {

        state.draft = payload;

    },

    setDraftId(state, payload) {
        state.draftId = payload;
    }

}
export const getters = {
    getDraft(state) {
        return state.draft;
    },

    getDraftId(state) {
        return state.draftId;
    }
}


export const actions = {

}
