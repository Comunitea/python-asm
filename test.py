#!/usr/bin/env python
# encoding: utf-8
from random import randint

username = '6BAB7A53-3B6D-4D5A-9450-702D2FAC0B11'
debug = True

from asm.picking import *
from asm.utils import services
from base64 import decodestring

print "ASM services"
services = services()
print services

with API(username, debug) as asm_api:
    print "Test connection"
    print asm_api.test_connection()

with Picking(username, debug) as picking_api:
    print "Send a new picking to ASM - Label PDF"

    data = {}
    #~ data['portes'] = 
    #~ data['servicio'] = 
    #~ data['horario'] = 
    #~ data['bultos'] = 
    #~ data['peso'] = 
    #~ data['volumen'] = 
    #~ data['declarado'] = 
    #~ data['dninob'] = 
    #~ data['fechaentrega'] = 
    #~ data['retorno'] = 
    #~ data['pod'] = 
    #~ data['podobligatorio'] = 
    #~ data['remite_plaza'] = 
    data['remite_nombre'] = 'Zikzakmedia SL'
    data['remite_direccion'] = 'Sant Jaume, 9'
    data['remite_poblacion'] = 'Vilafranca del Penedes'
    #~ data['remite_provincia'] = 'Barcelona'
    data['remite_pais'] = 'ES'
    data['remite_cp'] = '17800'
    #~ data['remite_telefono'] = 
    #~ data['remite_movil'] = 
    #~ data['remite_email'] = 
    #~ data['remite_departamento'] = 
    #~ data['remite_nif'] = 
    #~ data['remite_observaciones'] = 
    #~ data['destinatario_codigo'] = 
    #~ data['destinatario_plaza'] = 
    data['destinatario_nombre'] = 'Raimon Esteve Cusine'
    data['destinatario_direccion'] = 'Durruti 1937, 4art 2ona'
    data['destinatario_poblacion'] = 'Barcelona'
    #~ data['destinatario_provincia'] = 'Barcelona'
    data['destinatario_pais'] = 'ES'
    data['destinatario_cp'] = '08001'
    #~ data['destinatario_telefono'] = 
    #~ data['destinatario_movil'] = 
    #~ data['destinatario_email'] = 
    data['destinatario_observaciones'] = 'Testing ASM API - Create picking'
    #~ data['destinatario_att'] = 
    #~ data['destinatario_departamento'] = 
    #~ data['destinatario_nif'] = 
    data['referencia_c'] = randint(1000, 2000)
    #~ data['referencia_0'] = '12345'
    #~ data['importes_debido'] = 
    data['importes_reembolso'] = '25.69'
    #~ data['seguro'] = 
    #~ data['seguro_descripcion'] = 
    #~ data['seguro_importe'] = 
    #~ data['etiqueta'] = 
    #~ data['etiqueta_devolucion'] = 
    #~ data['cliente_codigo'] = 
    #~ data['cliente_plaza'] = 
    #~ data['cliente_agente'] = 

    reference, label, error = picking_api.create(data)
    print "Picking send %s" % reference
    with open("/tmp/asm-label.pdf","wb") as f:
        f.write(decodestring(label))
    print "Generated PDF label in /tmp/asm-label.pdf"

    data = {}
    data['codigo'] = reference
    #~ data['tipo_etiqueta'] = 'PNG' #EPL or DPL or JPG or PNG or PDF
    label = picking_api.label(data)
    with open("/tmp/asm-label-2.pdf","wb") as f:
        f.write(decodestring(label))
    print "Generated PDF label in /tmp/asm-label-2.pdf"
