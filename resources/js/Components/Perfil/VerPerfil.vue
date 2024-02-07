<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Pefil de la cuenta</h3>
        </div>

        <div class="d-flex flex-column" style="gap: 10px;">
            <div class="d-flex flex-row mx-auto aling-items-center" style="gap: 10px;">
                <v-btn class="bg-primary" prepend-icon="mdi-account-cog" :disabled="editarPerfil === true"
                    @click="editarPerfil = true">Actualizar
                    Perfil</v-btn>

                    <v-btn class="bg-terceary" prepend-icon="mdi-lock-reset" :disabled="editarPerfil === true"
                    @click="cambiarContraModal = true">Cambiar
                    contraseña</v-btn>

                    <v-btn class="bg-error" prepend-icon="mdi-account-remove" :disabled="editarPerfil === true"
                    @click="eliminarPerfilModal = true">
                    Eliminar cuenta
                </v-btn>
            </div>
           
            <div>
                <v-card class="bg-primary">
                    <v-card-title class="text-center text-h5">Informacion del perfil</v-card-title>
                    <v-divider color="black" :thickness="5"></v-divider>
                    <v-card-text>
                        <v-row align="center">
                            <v-col cols="12" sm="3">
                                <h4>Nombre:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <v-text-field v-if="editarPerfil === true" label="Nombre de la cuenta"
                                    variant="solo"></v-text-field>
                                <h4 v-else>Kerin Melendez</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Correo electronico:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <v-text-field v-if="editarPerfil === true" label="Correo" variant="solo"></v-text-field>
                                <h4 v-else>mio@gmail.com</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Edad:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <v-text-field v-if="editarPerfil === true" label="Edad" variant="solo"></v-text-field>
                                <h4 v-else>21</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Licencia:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <v-switch v-model="licencia" v-if="editarPerfil === true" hide-details true-value="Si"
                                    false-value="No" :label="`${licencia}`"></v-switch>
                                <h4 v-else>No</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Numero de licencia:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <v-text-field v-if="editarPerfil === true && licencia === 'Si'" label="Numero de licencia"
                                    variant="solo"></v-text-field>
                                <h4 v-else>21</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Tipo de cuenta:</h4>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <h4>Admin</h4>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions v-if="editarPerfil === true">
                        <v-btn class="bg-secondary">Guardar cambios</v-btn>
                        <v-btn class="bg-error" @click="editarPerfil = false">Cancelar</v-btn>
                    </v-card-actions>
                </v-card>
            </div>
        </div>

        <!--Modal de cambiar contraseña-->
        <v-dialog width="auto" v-model="cambiarContraModal" persistent>
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Cambiar contraseña</v-card-title>
                <v-card-subtitle class="pt-0">Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para
                    mantenerla
                    segura</v-card-subtitle>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>
                    <v-text-field color="primary" label="Contraseña actual" variant="solo"></v-text-field>
                    <v-text-field color="primary" label="Nueva contraseña" variant="solo"></v-text-field>
                    <v-text-field color="primary" label="Repetir nueva contraseña" variant="solo"></v-text-field>
                </v-card-text>
                <v-card-actions class="mt-3">
                    <v-btn class="bg-primary">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="cambiarContraModal = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!--Modal de Eliminar-->
        <v-dialog width="auto" v-model="eliminarPerfilModal" persistent>
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Eliminar Cuenta</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>¿Esta seguro de querer eliminar tu cuenta?</v-card-text>
                <v-card-text class="pt-0">Esta accion sera irreversible y todos tus datos <br> se borraran
                    permanentemente</v-card-text>
                <v-card-actions class="mt-3">
                    <v-btn class="bg-primary" @click="confirmarEliminar = true">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="eliminarPerfilModal = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog width="auto" v-model="confirmarEliminar" persistent>
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Eliminar Cuenta</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>Ingrese su contraseña para eliminar su cuenta</v-card-text>
                <v-card-text class="pt-0">
                    <v-text-field color="primary" label="Contraseña" variant="solo"></v-text-field>
                </v-card-text>
                <v-card-actions class="mt-3">
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="eliminarPerfil">Eliminar</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';
import notify from '@/plugins/notify.js'

let eliminarPerfilModal = ref(false);
const confirmarEliminar = ref(false);
const cambiarContraModal = ref(false);
const editarPerfil = ref(false);
const licencia = ref('No');



const eliminarPerfil = () => {
    confirmarEliminar.value = false
    eliminarPerfilModal.value = false
    notify('Cuenta eliminada', 'success')
}

</script>

<style lang="scss" scoped></style>