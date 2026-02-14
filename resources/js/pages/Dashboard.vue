<template>

    <div>
        <h1 class="header">Dashboard</h1>
        <div v-if="userInfo">
            Name: {{userInfo.name? userInfo.name : ''}} <br>
            Role: {{userInfo.role ? userInfo.role.title : 'Inactive'}}<br>
            Email: {{userInfo.email? userInfo.email : ''}}<br><br>
        </div>

    </div>


</template>

<script>
    import {userDetail} from "../helpers/axios";
    export default {
        name: "Dashboard",
        data() {
            return {
                user: null,
                income: null,
                expense: null,
                dailyBudget: {
                    total: 0
                },
                latestIncomes: [],
                latestExpenses: []
            }
        },
        computed: {
            userInfo:function () {
                return this.user = this.$store.state['auth'].user ? this.$store.state['auth'].user: {role:{title:''}};
            },
        },
        mounted() {
           /* userDetail( (response) => {
                this.user = response.data
                let payload = {user:response.data[0],isLoggedIn:true};
                this.$store.commit('setAuthUser', payload);
            },(error) => {
                console.log('Auth',error);
            });*/
        }

    }
</script>
