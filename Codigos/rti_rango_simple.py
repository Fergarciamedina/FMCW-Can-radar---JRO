import wave
import numpy as np
from scipy.io.wavfile import read
from scipy.fftpack import fft, ifft
import matplotlib.pyplot as plt

[fs, data] = read('running_outside_20ms.wav', 'r')

#constants
c = 299792458.0 #(m/s) speed of light

#radar parameters
Tp = 20 * 1E-3 #(s) pulse time
N = int(Tp * fs) # Number of samples per pulse
fi = 2260 * 1E6 #(Hz) LFM start frequency for example
ff = 2590 * 1E6 #(Hz) LFM stop frequency for example
BW = ff-fi #(Hz) transmti bandwidth
f = np.linspace(fi, ff, N/2) #instantaneous transmit frequency

#range resolution
rr = c/(2*BW)
max_range = rr*(N/2)

data = (-1.0 * data) / 32768
#the input appears to be inverted
trig = data[:,0]
s = data[:,1]

#parse the data here by triggering off rising edge of sync pulse
count = 0
thresh = 0
low_value_indexes = trig < thresh
high_value_indexes = trig > thresh

start = np.zeros([len(trig)], dtype = int)
start[low_value_indexes] = 0
start[high_value_indexes] = 1

sif = []
time = []

for x in range(100, len(start) - N):
    if ((start[x] == 1) and (np.mean(start[x-11:x-1]) == 0)):
        count = count + 1
        sif.append(s[x:x + N -1])
        time.append((x * 1.0) / fs)

        
sif = np.array(sif)
time = np.array(time)

sif = np.transpose(np.transpose(sif) - (np.mean(sif, axis = 1)))

zpad = (8 * N) / 2

sif2 = sif[2:sif.shape[0],:] - sif[1:sif.shape[0] - 1,:]

#RTI plot
v = 20 * np.log10(np.absolute(ifft(sif2, zpad)))
S = (v[:,1:v.shape[1]/2])

fig = plt.figure(1)
im = plt.imshow((S - np.amax(v)), aspect = 'auto', cmap = 'jet', vmin=-80,vmax=0,extent=[0,200,80,0])
cbar = plt.colorbar(im, orientation = 'vertical')
plt.show()

