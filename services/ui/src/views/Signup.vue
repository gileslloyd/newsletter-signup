<template>

    <div id="signup-form">
        <div class="signup-card">

            <div class="card-title">
                <h1>Sign-up for all the latest</h1>
            </div>

            <div class="content">
                <form method="POST" action="" @submit.prevent="signup">

                    <input id="first_name" type="text" name="first_name" title="first_name" placeholder="First Name" v-model="email_address" required autofocus>
                    <input id="surname" type="email" name="surname" title="surname" placeholder="Email" v-model="email_address" required>
                    <input id="email" type="email" name="email" title="email" placeholder="Email" v-model="email_address" required>
                    <input id="password" type="password" name="password" title="password" v-model="password" placeholder="Password" required>

                    <p class="help is-danger" v-show="validationFailed">
                        Invalid email address or password
                    </p>

                    <button type="submit" class="btn btn-primary">Sign me up!</button>
                </form>
            </div>
        </div>
    </div>

</template>

<script>
    import SignupAPI from './../classes/signupapi.js';

    export default {

        name: 'Signup',

        data() {
            return {
                'email_address': '',
                'password': '',
                'validationFailed': false,
            }
        },

        methods: {
            signup() {
                let self = this;
            }
        }

    };

</script>

<style scoped>

    #signup-form {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F7F7F7;
        overflow: hidden;
        padding: 2em;
    }

    .signup-card {
        background: #fff;
        width: 24rem;
        box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.11);
    }

    .card-title {
        background-color: #00b89c;
        padding: 2rem;
    }

    h1 {
        color: #fff;
        text-align: center;
        font-size: 1.2rem;
    }

    .content {
        padding: 2rem 2.5rem 5rem;
    }

    #email, #password {
        display: block;
        width: 100%;
        font-size: 1rem;
        margin-bottom: 1.75rem;
        padding: 0.25rem 0;
        border: none;
        border-bottom: 1px solid hsl(0, 0%, 86%);
        transition: all .5s;
    }

    span {
        margin-left: 0.5rem;
    }

    a {
        font-size: 0.8rem;
    }

    button {
        cursor: pointer;
        font-size: 1.2rem;
        color: hsl(171, 100%, 41%);
        border-radius: 4rem;
        display: block;
        width: 100%;
        background: transparent;
        border: 2px solid hsl(171, 100%, 41%);
        padding: 0.9rem 0 1.1rem;
        transition: color .5s, border-color .5s;
    }

    label {
        cursor: pointer;
    }

    input:focus,
    select:focus,
    textarea:focus,
    button:focus {
        outline: none;
    }

</style>
