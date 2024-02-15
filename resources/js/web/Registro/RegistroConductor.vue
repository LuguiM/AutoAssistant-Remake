<template>
    <v-container class="custom-container">
        <v-row>
            <v-col cols="12" sm="6" offset-sm="3">
                <v-card class="my-5  bg-black" rounded="xl">
                    <v-card-subtitle class="text-start ma-4">
                        <p class="text-white">Volver</p>
                    </v-card-subtitle>
                    <v-card-title class="text-center">
                        <v-img src="../images/Logos/sinLetrasLogo.png" height="100"></v-img>
                        <h5>AutoAssistant</h5>
                    </v-card-title>
                    <v-card-title class="text-uppercase text-center font-weight-black">
                        Creacion de cuenta
                    </v-card-title>
                    <v-card-text class="mx-sm-6">
                        <v-form @submit.prevent="sendForm()" validate-on="submit lazy">
                            <v-text-field v-model="form.nombre" label="Nombre" base-color="primary" :rules="[rules.required]" variant="solo"
                                rounded="xl" color="primary"></v-text-field>

                            <v-text-field v-model="form.edad" label="Edad" base-color="primary" :rules="[rules.required]" variant="solo"
                                rounded="xl" color="primary" class="mt-3" type="number"></v-text-field>

                            <v-switch v-model="form.licencia" color="primary" hide-details 
                                :label="`¿Cuentas con licencia? `"></v-switch>

                            <v-text-field v-if="form.licencia === true" v-model="form.numero_licencia" label="Numero de licencia" :rules="[rules.required, rules.numero_licencia]"
                                rounded="xl" variant="solo" color="primary" hint="Formato de licencia: XXXX-XXXXXX-XXX-X"
                                class="mt-3" @input="limpiarLicencia()"></v-text-field>

                            <v-text-field v-model="form.correo" label="Correo" :rules="[rules.required, rules.email]" variant="solo" rounded="xl"
                                color="primary" class="mt-3"></v-text-field>

                            <v-text-field v-model="password" :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                                :type="visible ? 'text' : 'password'" @click:append-inner="visible = !visible"
                                label="Contraseña" :rules="[rules.required, rules.counter]" rounded="xl" variant="solo"
                                color="primary" hint="La contraseña debe ser mayor a 8 digitos entre numeros y letras"
                                class="mt-3"></v-text-field>

                            <v-text-field v-model="repeatPassword" :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                                :type="visible ? 'text' : 'password'" @click:append-inner="visible = !visible"
                                label="Confirmar contraseña" :rules="[rules.required, rules.counter]" rounded="xl"
                                variant="solo" color="primary"
                                class="mt-3" @input="validarPassword()"></v-text-field>
                            
                            <p v-if="validPassword" class="text-error">Las contraseñas no son iguales</p>

                            <v-btn :loading="cargando" type="submit" block rounded="xl" class="bg-primary mt-3">Registrar</v-btn>
                        </v-form>
                    </v-card-text>

                    <v-card-text class="text-center">
                        ¿Ya tienes una cuenta? <a href="/IniciarSesion" class="text-white">Iniciar sesion</a>
                    </v-card-text>

                    <v-card-text class="bg-white text-center">
                        <h3 class="text-primary">Registrate con Google</h3>
                        <v-btn class="ma-2" color="primary" icon="mdi-google" variant="outlined"></v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

    </v-container>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../../Stores/auth'

const authStore = useAuthStore();

const form = ref({})
const password = ref('')
const repeatPassword = ref('')
const validPassword = ref(false)
const cargando = ref(false)

const rules = ref({
    required: value => !!value || 'Campo obligatorio.',
    counter: value => value.length >= 8 || 'Ingrese una contraseña mayor a 8 dígitos',
    email: value => {
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return pattern.test(value) || 'Correo inválido.'
    },
    numero_licencia: value => {
        const pattern = /^\d{4}-\d{6}-\d{3}-\d{1}$/
        return pattern.test(value) || 'El número de licencia debe tener el formato: XXXX-XXXXXX-XXX-X'
    }
});

const visible = ref(false);

const validarPassword = () =>{
    if(password.value == repeatPassword.value){
        validPassword.value = false;
    }else{
        validPassword.value = true;
    }
}

const limpiarLicencia = ()=>{
    if(form.value.licencia == false){
        form.value.numero_licencia = '';
    }
}

const sendForm = async () => {
    try {
        cargando.value = true;
        limpiarLicencia();
        form.value.password = password.value;
        await authStore.register(form.value);
    } finally {
        cargando.value = false;
    }
}




</script>

<style></style>