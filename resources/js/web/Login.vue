<template>
    <v-container class="custom-container">
        <v-row>
            <v-col cols="12" sm="6" offset-sm="3">
                <v-card class="my-5 text-center bg-black" rounded="xl">
                    <v-card-title>
                        <v-img src="../images/Logos/sinLetrasLogo.png" height="100"></v-img>
                        <h5>AutoAssistant</h5>
                    </v-card-title>
                    <v-card-title class="text-uppercase font-weight-black">
                        Iniciar Sesion
                    </v-card-title>
                    <v-card-text class="mx-sm-6">
                        <v-text-field label="Correo" :rules="[rules.required, rules.email]" variant="solo" rounded="xl"
                            color="primary"></v-text-field>

                        <v-text-field :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                            :type="visible ? 'text' : 'password'" @click:append-inner="visible = !visible"
                            label="Ingresar contraseña" :rules="[rules.required, rules.counter]" rounded="xl" variant="solo"
                            color="primary" hint="*La contraseña debe ser mayor a 8 digitos" class="mt-3"></v-text-field>
                        <v-btn block rounded="xl" class="bg-primary mt-3">Iniciar Sesion</v-btn>

                    </v-card-text>
                    <v-card-text class="d-sm-flex pt-0 align-center">
                        <v-checkbox label="Recuerdame" hide-details="auto"></v-checkbox>
                        <a href="#" class="text-white">¿Contraseña olvidada?</a>
                    </v-card-text>
                    <v-card-text class="pt-0">
                        ¿No tienes cuenta? <a href="#" class="text-white">Crear cuenta</a>
                    </v-card-text>

                    <v-card-text class="bg-white">
                        <h3 class="text-primary">Iniciar Sesion con Google</h3>
                        <v-btn class="ma-2" color="primary" icon="mdi-google" variant="outlined"></v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

    </v-container>
</template>

<script setup>
import { ref } from 'vue';

const rules = ref({
    required: value => !!value || 'Campo obligatorio.',
    counter: value => value.length >= 8 || 'Ingrese una contraseña mayor a 8 digitos',
    email: value => {
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return pattern.test(value) || 'Correo invalido.'
    },

});
const visible = ref(false);

</script>

<style></style>