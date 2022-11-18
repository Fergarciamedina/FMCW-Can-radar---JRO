def plot(self):
    self.x = self.data.times
    self.y = self.data.heights
    self.z = self.data[self.CODE]
    self.z = numpy.ma.masked_invalid(self.z)

    if self.decimation is None:
        x, y, z = self.fill_gaps(self.x, self.y, self.z)
    else:
        x, y, z = self.fill_gaps(*self.decimate())

    for n, ax in enumerate(self.axes):
        self.zmin = self.zmin if self.zmin else numpy.min(self.z)
        self.zmax = self.zmax if self.zmax else numpy.max(self.z)
        if ax.firsttime:
            ax.plt = ax.pcolormesh(x, y, z[n].T,
                                    vmin=self.zmin,
                                    vmax=self.zmax,
                                    cmap=plt.get_cmap(self.colormap)
                                    )
            if self.showprofile:
                ax.plot_profile = self.pf_axes[n].plot(
                    self.data['rti'][n][-1], self.y)[0]
                ax.plot_noise = self.pf_axes[n].plot(numpy.repeat(self.data['noise'][n][-1], len(self.y)), self.y,
                                                        color="k", linestyle="dashed", lw=1)[0]
        else:
            ax.collections.remove(ax.collections[0])
            ax.plt = ax.pcolormesh(x, y, z[n].T,
                                    vmin=self.zmin,
                                    vmax=self.zmax,
                                    cmap=plt.get_cmap(self.colormap)
                                    )
            if self.showprofile:
                ax.plot_profile.set_data(self.data['rti'][n][-1], self.y)
                ax.plot_noise.set_data(numpy.repeat(
                    self.data['noise'][n][-1], len(self.y)), self.y)