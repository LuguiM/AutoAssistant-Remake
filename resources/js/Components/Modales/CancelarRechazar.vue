<template>
    <v-dialog v-model="dialog" persistent width="auto">
        <template v-slot:activator="{ props }" v-if="prop.type ==='text'">
            <v-btn v-if="prop.title === 'Rechazar'" v-bind="props" class="bg-error" prepend-icon="mdi-close-circle-outline">Rechazar</v-btn>

            <v-btn v-else v-bind="props"  class="bg-error" prepend-icon="mdi-delete-outline">Cancelar</v-btn>

        </template>
        <template v-slot:activator="{ props }" v-else="prop.type ==='icon'">
            <v-btn v-if="prop.title === 'Rechazar'" v-bind="props" variant="flat" density="compact" icon="mdi-close-circle-outline"></v-btn>

            <v-btn v-else v-bind="props" variant="flat" density="compact" icon="mdi-delete-outline"></v-btn>
        </template>

            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">{{ prop.title }} servicio</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>

                <v-card-text class="text-h4" v-if="prop.title === 'Cancelar'"><v-icon color="error">mdi-delete-outline</v-icon></v-card-text>
                <v-card-text class="text-h4" v-else><v-icon color="error">mdi-close-circle-outline</v-icon></v-card-text>

                <v-card-text>¿Esta seguro de querer <span class="text-lowercase">{{ prop.title }}</span> este servicio?</v-card-text>
                <v-card-text v-if="prop.title === 'Rechazar'" class="pt-0">Deje un motivo para poder rechazar el servicio </v-card-text>
                <v-card-text v-else class="pt-0">Esta accion sera irreversible</v-card-text>

                <v-card-text v-if="prop.title === 'Rechazar'">
                    <v-textarea v-model="form.motivo" label="Motivo" variant="solo" auto-grow
                    rows="4"
                    row-height="30">
                    </v-textarea>
                </v-card-text>

                <v-card-actions class="mt-3">
                    <v-btn class="bg-primary" @click="cancelarRechazar">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="dialog = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        
    </v-dialog>
    
</template>

<script setup>
import {ref, defineProps} from 'vue'
import notify from '@/plugins/notify.js'
import { putData } from '@/plugins/api.js';



const dialog = ref(false);

const prop = defineProps({
    title: {
        type: String,
        required: true,
        default:'Cancelar'
    },
    type: {
        type: String,
        required: true,
        default: 'icon'
    },
    id: {
        type: Number,
        required: true,
        default: null
    }

})
const emit = defineEmits(['actualizar'])

const form = ref({})

const cancelarRechazar = async() =>{

    try{
        if(prop.title === 'Rechazar'){
            form.value.estado_id = 5;
            try{
                await putData(('updateEstado/' + prop.id),form.value, { headers: { 'Content-Type': 'application/json' } });
            }catch(error){
                console.log(error)
            }finally{
                emit('actualizar')
                dialog.value = false
            }
        }else{
            form.value.estado_id = 4;
            await putData(('updateEstado/' + prop.id),form.value, { headers: { 'Content-Type': 'application/json' } });
            emit('actualizar')
            dialog.value = false

        }
    }catch(error){
        notify(error,'error');
    }
}

</script>