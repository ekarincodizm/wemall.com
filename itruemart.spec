Name            : itruemart
Summary         : iTrueMart PHP source code
Version         : %{?version}%{!?version:1.0.0}
Release         : %{?release}%{!?release:0}

Group           : Applications/File
License         : (c)Douglas Gibbons

BuildArch       : %{?arch}%{!?arch:x86_64}
BuildRoot       : %{_tmppath}/%{name}-%{version}-root

%define projectname itruemart

# Use "Requires" for any dependencies, for example:
# Requires        : httpd

# Description gives information about the rpm package. This can be expanded up to multiple lines.
%description
iTrueMart PHP source code


# Prep is used to set up the environment for building the rpm package
# Expansion of source tar balls are done in this section
%prep

# Used to compile and to build the source
%build

%pre 
if [ "$1" = "1" ]; then
  echo "pre ==> for new install"
elif [ "$1" = "2" ]; then
  echo "pre ==> for upgrade"
fi

# The installation.
# We actually just put all our install files into a directory structure that mimics a server directory structure here
%install
rm -rf $RPM_BUILD_ROOT
install -d -m 755 $RPM_BUILD_ROOT/var/www/itruemart
install -d -m 755 $RPM_BUILD_ROOT/data/projects/%{projectname}/%{version}-%{release}/%{projectname}/
cp ../SOURCES/*.tar.gz $RPM_BUILD_ROOT/data/projects/

# Contains a list of the files that are part of the package
# See useful directives such as attr here: http://www.rpm.org/max-rpm-snapshot/s1-rpm-specref-files-list-directives.html
%files
%defattr(0644, nginx, nginx, 0755)
%dir %attr(0755, root, root) /var/www
%dir /var/www/itruemart/
%dir /data/projects/
/data/projects/*.tar.gz
%dir /data/projects/%{projectname}/%{version}-%{release}/
%dir /data/projects/%{projectname}/%{version}-%{release}/%{projectname}/

%post
echo "post ==> for new install"
mv /data/projects/%{projectname}-*.tar.gz /data/projects/%{projectname}/%{version}-%{release}
tar xfz /data/projects/%{projectname}/%{version}-%{release}/%{name}-*.tar.gz -C /data/projects/%{projectname}/%{version}-%{release}/%{projectname}
ln -f -s -n /data/projects/%{projectname}/%{version}-%{release}/%{name}/ /var/www/itruemart/%{projectname}
/bin/ls -dt /data/projects/%{projectname}/* | tail -n +3 | xargs rm -Rf
rm /data/projects/%{projectname}/%{version}-%{release}/%{name}-*.tar.gz

%preun
if [ "$1" = "1" ]; then
  echo "preun ==> for upgrade"
elif [ "$1" = "0" ]; then
  echo "preun ==> for uninstall"
  rm -f /var/www/itruemart/%{projectname}
  rm -rf /data/projects/%{projectname}
fi

%postun
if [ "$1" = "1" ]; then
  echo "postun ==> for upgrade"
elif [ "$1" = "0" ]; then
  echo "postun ==> for uninstall"
fi

# Used to store any changes between versions
%changelog