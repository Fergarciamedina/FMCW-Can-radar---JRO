import pyaudio
import wave
import numpy as np
from scipy.io.wavfile import read
from scipy.fftpack import fft, ifft
from scipy.signal import decimate
from constants import *
import math
import time
import paho.mqtt.client as paho
from datetime import datetime
import json
import matplotlib.pyplot as plt

class stream():
    def __init__(self):
        self.audio_recording = pyaudio.PyAudio()
        self.stream = self.audio_recording.open(format=FORMAT, channels=CHANNELS,
                                                rate=RATE, input=True,
                                                frames_per_buffer=NUMBER_OF_POINTS)

    def return_stream(self):
        frames = []
        for i in range(0, 3 * int(math.ceil(NUMBER_OF_POINTS * 1.0/ CHUNK))):
            data = self.stream.read(CHUNK, exception_on_overflow = False)
            frames.append(data)
        wf = wave.open(WAVE_OUTPUT_FILENAME, 'wb')
        wf.setnchannels(CHANNELS)
        wf.setsampwidth(self.audio_recording.get_sample_size(FORMAT))
        wf.setframerate(RATE)
        wf.writeframes(b''.join(frames))
        wf.close()
        [rate, data] = read(WAVE_OUTPUT_FILENAME, 'r')
        #data = data[:5 * NUMBER_OF_POINTS,:]
        return data

    def stop_stream(self):
        self.stream.stop_stream()
        self.stream.close()
        self.audio_recording.terminate()

class doppler_velocity():
    def __init__(self, data, client):
        self.client = client
        self.data = data

    def return_doppler_velocity(self):
        self.data = (-1.0 * self.data) / 32768.0
        trig = self.data[:,0]
        self.data = np.asarray(self.data[:,1])
        trig = np.diff(trig)
        count = 0
        thresh = 0
        low_value_indexes = trig < thresh
        high_value_indexes = trig > thresh

        start = np.zeros([len(trig)], dtype = int)
        start[low_value_indexes] = 0
        start[high_value_indexes] = 1
        sif = []
        aux = []
        for x in range(50, len(start)):
            if (start[x] == 1) and (np.mean(start[x-11:x-1]) == 0):
                count = count + 1
                aux.append(trig[x+20:NUMBER_OF_POINTS / 2.0 + x - 1 - 20])
                sif.append(self.data[x+20:NUMBER_OF_POINTS / 2.0 + x -1 - 20]) #(NUMBER_OF_POINTS / 2.0)
                break

        self.data = sif
        self.data = np.asarray(self.data)

        aux = np.asarray(aux)

        #plt.figure()
        #plt.plot(self.data[0])
        #plt.plot(aux[0])
        #plt.show()
        #print self.data.shape
        #print self.data.shape
        #self.data = self.data - self.data.mean(axis = 0)
        self.data = decimate(x=self.data,q=3,n=11,ftype="fir")
        #print self.data
        w = np.hanning(self.data.shape[1])
        #print self.data.shape
        aux = np.absolute(ifft(self.data[0]*w))#, n = ZERO_PADDING))#, n = ZERO_PADDING/6))
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
        data = json.dumps(data)
        self.client.publish("can_radar", data, qos=0)

record_test = stream()

client = paho.Client()
#client.connect("104.236.221.13")
client.connect(IP_SERVER, port="1883")
client.loop_start()

while True:
    velocity_test = doppler_velocity(record_test.return_stream(), client)
    velocity_test.return_doppler_velocity()
    time.sleep(0.25)
