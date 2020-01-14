<template>

    <section>

        <div id="signup-form">
            <div class="signup-card">

                <div class="card-title">
                    <h1>Sign-up for all the latest</h1>
                </div>

                <div class="content">
                    <form method="POST" action="" @submit.prevent="signup">

                        <input id="first_name" type="text" name="first_name" title="first_name" placeholder="First Name" v-model="first_name" required autofocus>
                        <input id="surname" type="text" name="surname" title="surname" placeholder="Surname" v-model="surname" required>
                        <input id="email_address" type="email" name="email_address" title="email_address" placeholder="Email Address" v-model="email_address" required>
                        <input id="confirm_email" type="email" name="confirm_email" title="confirm_email" v-model="confirm_email" placeholder="Confirm Email" required>

                        <p class="help is-danger" v-show="validationFailed">
                            {{ error }}
                        </p>

                        <button type="submit" class="btn btn-primary">Sign me up!</button>
                    </form>
                </div>
            </div>
        </div>

        <modal v-show="successModalIsVisible" @close="resetForm()">

            <template v-slot:title>Sign-up Complete</template>

            <p>{{ email_address }} is now signed up to our mailing list</p>
            <p>You are definitely <i>not</i> going to get spammed!</p>

        </modal>

    </section>

</template>

<script>
    import SignupAPI from './../classes/signupapi.js';
    import modal from './../components/Modal.vue';

    export default {

        name: 'Signup',

        components: { modal },

        data() {
            return {
                'first_name': '',
                'surname': '',
                'email_address': '',
                'confirm_email': '',
                'validationFailed': false,
                'error': '',
                'successModalIsVisible': false
            }
        },

        methods: {
            clearError() {
                this.error = '';
                this.validationFailed = true;
            },

            resetForm() {
                this.first_name = '';
                this.surname = '';
                this.email_address = '';
                this.confirm_email = '';
                this.successModalIsVisible = false;
            },

            signup() {
                this.clearError();
                let self = this;

                SignupAPI.post(
                    'signup',
                    {
                        first_name: this.first_name,
                        surname: this.surname,
                        email_address: this.email_address,
                        confirm_email: this.confirm_email
                    },
                    (response) => {
                        self.successModalIsVisible = true;
                    },
                    (error) => {
                        self.error = error.response.data.body.error;
                        self.validationFailed = true;
                    }
                );
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

    input {
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
