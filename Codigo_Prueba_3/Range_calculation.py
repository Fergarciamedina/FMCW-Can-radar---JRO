from constants import *
from scipy.fftpack import fft, ifft
from scipy.signal import decimate

import json
import paho.mqtt.client as paho
class Range_calculation():
    def __init__(self, data, client):
        self.client = client
        self.data = data

    def return_range(self):
        print "\ndata init no divided"
        print self.data
        self.data = (-1.0 * self.data) / 32768.0 # se divide entre 2 1E15

        print "\ndata divided and multiplied by -1 --- the input appears to be inverted "
        print self.data

        trig = self.data[:,0]
        print "\nTrigger array not binary discretized"
        print trig

        # test plot trig 1
        plt.figure(1)
        plt.subplot(311)
        plt.plot(trig[0:5000])
        #plt.show()
        # end test

        self.data = np.asarray(self.data[:,1])
        print "\ndata array"
        print self.data

        ''' ******************* can be errased!? ******************* '''
        ''' esto no se porque no ponen bien. En principio, la idea de tener
        un trigger en alto y otro en bajo bien demarcada como se meustra en la imagen
        podria saber cuando es de flanco de subida y de bajada pero despues, al discretizarlo
        la senal no se muestra como cuadrada si no como una figura de varias lineas .
        En esta grafica aveces se ve, marcado con mas lineas, donde podria estar el flanco
        el flanco de subida y de bajada. no se porque esta!!!
        '''

        trig = np.diff(trig)
        print "\ntrigger con diff not binary discretized"
        print trig
        # test plot trig 2
        #plt.figure(2)
        plt.subplot(312)
        plt.plot(trig[0:5000])
        #plt.show()
        # end test
        ''' ******************************************************* '''

        count = 0
        thresh = 0
        low_value_indexes = trig < thresh
        high_value_indexes = trig > thresh

        start = np.zeros([len(trig)], dtype = int)
        start[low_value_indexes] = 0
        start[high_value_indexes] = 1
        print "\ntrigger con diff discretized"
        print start
        # test plot trig 3
        #plt.figure(2)
        plt.subplot(313)
        plt.plot(start[0:5000])
        #plt.show()
        # end test

        sif = []
        aux = []

        for x in range(50, len(start)):
            if (start[x] == 1) and (np.mean(start[x-11:x-1]) == 0):
                #count = count + 1 # esto esta en el codigo de matlab, aca no lo usan en ningun programa de python
                sif.append(self.data[x+20:int(NUMBER_OF_POINTS / 2.0 + x -1 - 20)]) #(NUMBER_OF_POINTS / 2.0)
                aux.append(trig[x+20:int(NUMBER_OF_POINTS / 2.0 + x - 1 - 20)])
                break

        self.data = sif
        print "\n"
        print self.data
        self.data = np.asarray(self.data)
        print "\nSelf.data - sif[0]"
        print self.data
        aux = np.asarray(aux)
        print self.data.shape
        print "\nAux"
        print aux[0]

        #plt.figure()
        #plt.plot(self.data[0])
        #plt.plot(aux[0])
        #plt.show()
        #print self.data.shape
        #print self.data.shape
        #self.data = self.data - self.data.mean(axis = 0)
        self.data = decimate(x=self.data,q=3,n=11,ftype="fir")
        print "\nselfData"
        print self.data.shape
        w = np.hanning(self.data.shape[1])
        print"\nW"
        print w[0:50]

        aux = np.absolute(ifft(self.data[0]*w, n = ZERO_PADDING))#, n = ZERO_PADDING/6))
        print "\nifft - aux "
        print aux
        #aux = aux - np.mean(aux)
        #aux = np.sum(aux,axis = 0)
        v =  20 * np.log10(aux)
        #v = np.fft.fftshift(v)
        v = v[0:v.shape[0]/4]
        #print v
        #v = v[0:100]
        #print v.shape
        v = v.astype(int)
        print np.average(v)

        v  = json.dumps(v.tolist())
        data = { "heights": v,
                 "time": datetime.now().strftime("%G-%m-%d %H:%M:%S.%f").rstrip('0')}

        print "\ndata"
        print data
        data = json.dumps(data)
        self.client.publish("can_radar", data, qos=0)

        ##print "\ndata JS"
        ##print data
        ##return data
        #print "data - Heights and Time"
        #print data["heights"].shape
        '''
        fig = plt.figure(5)
        im = plt.imshow(data["heights"], aspect = 'auto', cmap = 'jet')
        cbar = plt.colorbar(im, orientation = 'vertical')
        plt.show()

        #plt.plot_date(data["time"], data["heights"])

        data = json.dumps(data)
        self.client.publish("can_radar", data, qos=0)
        '''
