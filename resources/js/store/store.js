
// routes

import Axios from "axios";
import VueToastr$1 from "vue-toastr";

// create a store
export default {
    
            state: {
                user: localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null,
                isAuthenticated: localStorage.getItem('token') ? true : false,
                isLoading: false,
                person: null,
            },
            mutations: {
                setUser(state, user) {
                    state.user = user;
                },
                setIsAuthenticated(state, isAuthenticated) {
                    state.isAuthenticated = isAuthenticated;
                },
                setIsLoading(state, isLoading) {
                    state.isLoading = isLoading;
                },
                setPerson(state, person) {
                    state.person = person;
                }
            },
            getters: {
                user(state) {
                    return state.user;
                },
                isAuthenticated(state) {
                    return state.isAuthenticated;
                },
                isLoading(state) {
                    return state.isLoading;
                },
                person(state) {
                    return state.person
                }

            },

            actions: {
                
            }
            
}
    
