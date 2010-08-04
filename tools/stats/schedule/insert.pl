#!/usr/bin/perl -w

use strict;
use Data::Dumper;
use URI::Escape;
use HTML::TreeBuilder;
use DBI;
use LWP;
use HTTP::Request;
use HTTP::Response;
use JSON;

my @files = </root/applebees/json/*>;
my $dbh = DBI->connect('dbi:Pg:dbname=ahappierhour','happy','happy');
my $sql = "insert into locations (location_id,name,address1,city,state,latitude,longtitude,map_url,phone,franchise_id,bulk_import) values (nextval('location_seq'),?,?,?,?,?,?,?,?,3,true)";
my $inssth = $dbh->prepare($sql);

foreach my $file (@files) {
  open FILE, $file or die "Couldn't open file; $!\n";
  my $json_str = join("",<FILE>);
  close FILE;
  my $json = new JSON;
  my $json_text = $json->allow_nonref->utf8->relaxed->decode($json_str);

  if ($json_text->{"responseStatus"} eq 200 && defined($json_text->{"responseData"}->{"results"}[0])) {
      my $loc = $json_text->{"responseData"}->{"results"}[0];
      my $name = $loc->{"titleNoFormatting"};
      my $address = $loc->{"streetAddress"};
      my $city = $loc->{"city"};
      my $state = $loc->{"region"};
      my $lat = $loc->{"lat"};
      my $long = $loc->{"lng"};
      my $map = $loc->{"staticMapUrl"};
      my $phone = $loc->{"phoneNumbers"}[0]->{"number"};
      $phone =~ s/\D//g;
  
      print "\n\n$name $address $city $state $phone $lat $long $map\n\n";
  
      $inssth->execute($name,$address,$city,$state,$lat,$long,$map,$phone);
  }
}

$inssth->finish();
$dbh->disconnect();
exit;

sub trim {
    my $string = shift;
    return '' if not defined $string;

    $string =~ s/^\s+//;
    $string =~ s/\s+$//;

    return $string;
}
